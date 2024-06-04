<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Position;
use App\Models\Skill;
use App\Models\Vacancy;
use phpQuery;


/**
 * Сервис взаимодействия с вакансиями
 */
class VacanciesService
{
    /**
     * Считывает html-страницу в строку
     *
     * Необходим для  дальнейшего парсинга
     */
    private function getDocument(string $url): bool|string
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    /**
     * Метод получения вакансий с сайта https://rntgroup.com/career/vacancies/
     *
     * Проходит по всем вакансиям с сайта.
     * Если нет такой специализации, то добавляет новую. Если в вакансии указаны навыки, которых нет в базе, добавляет
     * из. Если в базе уже есть такая же открытая вакансия, то возвращает её.
     *
     * @return array массив вакансий с внещнего сервиса
     */
    public function getOuterVacancies(): array
    {
        $page = $this->getDocument('https://rntgroup.com/career/vacancies/');
        $pq = phpQuery::newDocument($page);

        $vacancyCards = $pq->find('.col-12.tariff');
        $vacancyLinks = [];

        foreach ($vacancyCards as $vacancy) {
            $link = pq($vacancy)->find('.btn')->attr('href');
            if ($link[0] != 'h') {
                $link = 'https://www.rntgroup.com'.$link;
            }
            if (!in_array($link, $vacancyLinks)) {
                $vacancyLinks[] = $link;
            }
        }

        $vacancies = [];

        foreach ($vacancyLinks as $link) {
            $detailVacancyPage = $this->getDocument($link);
            $pq = phpQuery::newDocument($detailVacancyPage);

            $positionName = $pq->find('h1.block-title-text')->text();
            $position = Position::firstOrCreate(['name' => $positionName]);


            $foundVacancy = Vacancy::where('department_id', Vacancy::$DEFAULT_DEPARTMENT_ID)
                ->where('position_id', $position->id)
                ->where('is_closed', false)->first();


            if ($foundVacancy != null)
            {
                $vacancies[] = $foundVacancy->toArray();
                continue;
            }

            $description = trim(
                preg_replace(
                    '(\r\n|\r|\n)',
                    '',
                    $pq->find('.block-subtitle')->text()
                )
            );
            $hasSocialSupport = false;
            $isFlexible = false;
            $isOnline = false;
            $schedule = '';
            $isFullTime = true;

            foreach ($pq->find('.service-container .service-name') as $service) {
                switch (trim($service->textContent)) {
                    case 'Социальный пакет':
                        $hasSocialSupport = true;
                        break;
                    case 'Гибкий график работы':
                        $isFlexible = true;
                        $schedule = trim($service->nextElementSibling->textContent);
                        break;
                    case 'Удалённый формат работы':
                        $isOnline=true;
                        $schedule = trim($service->nextElementSibling->textContent);
                        break;
                    // todo: добавить проверку на полный/неполный рабочий день
                }
            }

            $skills = $pq->find('.block-desc ul li');
            $skillNames = [];

            foreach ($skills as $skill) {
                $names = [];
                preg_match_all ('([a-zA-Z#+]+)', $skill->textContent, $names);

                // Потому что возвращает двумерный массив
                if (count($names[0]) != 0) {
                    foreach ($names[0] as $name)
                    {
                        $skillNames[] = $name;
                    }
                }
            }

            $vacancy = new Vacancy();
            $vacancy->position()->associate($position);

            foreach ($skillNames as $skillName) {
                $vacancy->skills()->attach(Skill::firstOrCreate(['name' => $skillName]));
            }

            $vacancy->description = $description;
            $vacancy->salary = null;
            $vacancy->department()->associate(
                Department::where('id', Vacancy::$DEFAULT_DEPARTMENT_ID)->first());
            $vacancy->has_social_support = $hasSocialSupport;
            $vacancy->is_flexible = $isFlexible;
            $vacancy->is_fulltime = $isFullTime;
            $vacancy->is_online = $isOnline;
            $vacancy->schedule = $schedule;
            $vacancy->is_outer = true;
            $vacancy->is_closed = false;
            $vacancy->save();
            $vacancy->refresh();

            $vacancies[] = $vacancy->toArray();
        }

        return $vacancies;
    }

    /**
     * Метод для получения вакансий изнутри системы
     *
     * Выбирает все вакансии с is_outer==false
     *
     * @return array массив вакансий из нашей системы
     */
    public function getInnerVacancies(): array
    {
        return Vacancy::where('is_closed', false)->where('is_outer', false)->get()->toArray();
    }

}