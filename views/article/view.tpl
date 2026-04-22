{extends file="layouts/main.tpl"}

{block name="title"}
    {$article.title}
{/block}

{block name="content"}
    <h1>{$article.title}</h1>
    <p>
        Date: {$article.date|date_format:"%B %e, %Y"}
    </p>
    <p>
        Views: {$article.views}
    </p>
    <p>
        {$article.content}
    </p>
    <h2>Похожие статьи</h2>
    {if empty($similarArticles)}
        статей не найдено
    {else}
        <ul>
            {foreach $similarArticles as $similarArticle}
                <li>
                    <a href="/article/{$similarArticle.id}">{$similarArticle.title} {$similarArticle.id}</a>
                </li>
            {/foreach}
        </ul>
    {/if}

{/block}