<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Employment;
use App\Models\Experience;
use App\Models\Position;
use App\Models\Skill;
use App\Models\Vacancy;
use App\Parser;
use Exception;
use phpQuery;


/**
 * Сервис взаимодействия с вакансиями
 */
class VacancyService
{
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
        $page = Parser::getDocument('https://rntgroup.com/career/vacancies/');
        $pq = phpQuery::newDocument($page);

        $vacancyCards = $pq->find('.col-12.tariff');
        $vacancyLinks = [];

        foreach ($vacancyCards as $vacancy) {
            $link = pq($vacancy)->find('.btn')->attr('href');
            if ($link[0] != 'h') {
                $link = 'https://www.rntgroup.com' . $link;
            }
            if (!in_array($link, $vacancyLinks)) {
                $vacancyLinks[] = $link;
            }
        }

        $vacancies = [];

        foreach ($vacancyLinks as $link) {
            $detailVacancyPage = Parser::getDocument($link);
            $pq = phpQuery::newDocument($detailVacancyPage);

            $positionName = $pq->find('h1.block-title-text')->text();
            $position = Position::firstOrCreate(['name' => $positionName]);


            $foundVacancy = Vacancy::where('department_id', Vacancy::$DEFAULT_DEPARTMENT_ID)
                ->where('position_id', $position->id)
                ->where('is_closed', false)->first();


            if ($foundVacancy != null) {
                $vacancies[] = $foundVacancy->load(
                    [
                        'employment',
                        'department.company.image',
                        'experience',
                        'city',
                        'position'
                    ])
                    ->toArray();
                continue;
            }

            // Парсим блок Задачи - это блок обязаннасти во внутренних вакансиях
            try {
                $responsibilities = $this->cleanFromLinebreaks($pq->find('.block-subtitle h3')->next()->html());
            } catch (Exception $e) {
                $responsibilities = null;
            }

            // Парсим требуемый опыт работы
            $fullPageText = $pq->text();

            try {
                preg_match_all('/от \d+/', $fullPageText, $matches);
                $experienceInt = (int)mb_substr($matches[0][0], 3);

                if ($experienceInt < 3) {
                    $experience = Experience::where('name', 'Опыт от 1 года')->first();
                }
                else if ($experienceInt < 5) {
                    $experience = Experience::where('name', 'Опыт от 3 лет')->first();
                }
                else {
                    $experience = Experience::where('name', 'Опыт от 5 лет')->first();
                }
            } catch (Exception $e) {
                $experience = null;
            }


            // Парсим описание
            $description = $pq->find('.block-subtitle');
            try {
                $description->find('h3')->next()->remove();
                $description->find('h3')->remove();
                $description = $this->cleanFromLinebreaks($description->text());

            } catch (Exception $e) {
                $description = $this->cleanFromLinebreaks($pq->find('.block-subtitle')->text());
            }

            // Парсим данные из карточек внизу вакансии
            $hasSocialSupport = false; // Есть ли соц поддержка
            $isFlexible = false; // Гибкий ли график
            $isOnline = false;
            $schedule = ''; // Иногда в этих карточках указан график работы
            $employment = Employment::where('name', 'Полная занятость')->first();

            foreach ($pq->find('.service-container .service-name') as $service) {
                switch (trim(pq($service)->text())) {
                    case 'Социальный пакет':
                        $hasSocialSupport = true;
                        break;
                    case 'Гибкий график работы':
                        $isFlexible = true;
                        $schedule = trim($this->cleanFromLinebreaks(pq($service)->next()->text()));
                        break;
                    case 'Удалённый формат работы':
                        $isOnline = true;
                        $schedule = trim($this->cleanFromLinebreaks(pq($service)->next()->text()));
                        break;
                }
            }

            // Парсим блок Требуемые навыки и знания - блок Требования во внутренних
            $requirements = $this->cleanFromLinebreaks($pq->find('.block-desc ul')->eq(0)->html());

            // Парсим блок Будет плюсом - блок Дополнительно во внутренних вакансиях
            try {
                $additional = $this->cleanFromLinebreaks($pq->find('.block-desc ul')->eq(1)->html());
            } catch (Exception $e) {
                $additional = null;
            }

            // Парсим скиллы. Если скила нет в нашей базе - добавляем. Сейчас скилы - это все иностранные слова
            $skills = $pq->find('.block-desc ul li');
            $skillNames = [];

            foreach ($skills as $skill) {
                $names = [];
                preg_match_all('([a-zA-Z#+]+)', pq($skill)->text(), $names);

                // Потому что возвращает двумерный массив
                if (count($names[0]) != 0) {
                    foreach ($names[0] as $name) {
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
            $vacancy->department()->associate(
                Department::where('id', Vacancy::$DEFAULT_DEPARTMENT_ID)->first());
            $vacancy->has_social_support = $hasSocialSupport;
            $vacancy->is_flexible = $isFlexible;
            $vacancy->experience()->associate($experience);
            $vacancy->employment()->associate($employment);
            $vacancy->is_online = $isOnline;
            $vacancy->schedule = $schedule;
            $vacancy->is_outer = true;
            $vacancy->is_closed = false;
            $vacancy->responsibilities = $responsibilities;
            $vacancy->requirements = $requirements;
            $vacancy->additional = $additional;

            $vacancy->save();

            $vacancy->load(
                [
                    'employment',
                    'department.company.image',
                    'experience',
                    'city',
                    'position'
                ]);

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
        $vacancies = Vacancy::where('is_closed', false)->where('is_outer', false)->get()
            ->load(
                [
                    'employment',
                    'department.company.image',
                    'experience',
                    'city',
                    'position'
                ]);

        return $vacancies->toArray();
    }

    /**
     * Метод для получения вакансий изнутри системы для hr-панели
     *
     * @return array массив вакансий из нашей системы
     */
    public function getInnerVacanciesHR(?int $statusID, ?int $specializationID): array
    {

        $statusID = $statusID != null ? $statusID : 1;
        $vacanciesBuilder = Vacancy::where('status_id', $statusID)->where('is_outer', false);

        if ($specializationID != null){
            $vacanciesBuilder->where('specialization_id', $specializationID);
        }

        $vacancies = $vacanciesBuilder->get()
            ->load(
                [
                    'accountable.user',
                    'city',
                    'position'
                ]);

        return $vacancies->toArray();
    }

    /**
     * Метод получения подробной информации о вакансии по id
     *
     * @param int $id - id вакансии
     * @return array
     */
    public function getVacancyByID(int $id): array
    {
        $vacancy = Vacancy::where('id', $id)->get()->first()
            ->load(
                [
                    'employment',
                    'department.company.image',
                    'department.company.building.street.city.country',
                    'experience',
                    'city',
                    'position',
                    'skills',
                    'image',
                ]);

        return $vacancy->toArray();
    }

    /**
     * Метод удаления перенос \r\n из строки
     *
     * @param string $string - строка
     * @return string - строка без переносов
     */
    private function cleanFromLinebreaks(string $string): string
    {
        return preg_replace('/[\r\n]+/', '', $string);
    }

}

