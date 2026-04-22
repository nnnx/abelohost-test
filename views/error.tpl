{extends file="layouts/main.tpl"}

{block name="title"}
    Ошибка
{/block}

{block name="content"}
    <h1>{$httpCode}</h1>
    {$message}
{/block}