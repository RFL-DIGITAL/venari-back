<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.9.0/swagger-ui.css" integrity="sha512-9ZJfeEZ6DAr3pstOThylJAyPbhr+BXMiyPsiCWmozVeJrcInppRXLZ9sUOL64n7H7DHsdDlSCRI3qk5/clvnXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.9.0/swagger-ui-bundle.js" integrity="sha512-zhe87uwwYxuIV1PLaXwG9fusW9mDez5/BeXza7IXhbl9USp0IAxsJry9tzZu8/9+aAadV/UEEe0NQf0V6ChYkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.9.0/swagger-ui-standalone-preset.js" integrity="sha512-mW5PsbxbBbDGGKxF/Wq1wu9WcFBkceXId0D00smBM6H6I33sgOYhKGwOjYdUwXj5FMFkPU5n4wO8G/Rx5FfMGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Swagger UI</title>
</head>
<div id="swagger-ui"></div>
<script type="text/javascript">
  window.onload = function() {
    // Build a system
    const ui = SwaggerUIBundle({
      url: "/build/swag.json",
      dom_id: '#swagger-ui',
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      layout: "BaseLayout",

    })
  }
</script>
</body>
</html>
