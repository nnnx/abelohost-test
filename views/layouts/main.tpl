<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" crossorigin="" href="/css/style.css">
    <title>{block name="title"}{/block}</title>
</head>
<body>

<header class="header">
    <div class="container">
        <a href="/">AbeloHost test</a>
    </div>
</header>

<div class="blog">
    <div class="container">
        {block name="content"}{/block}
    </div>
</div>

<footer class="footer">
    Copyright © 2025. All Rights Reserved.
</footer>

</body>
</html>