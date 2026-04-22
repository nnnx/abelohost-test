{extends file="layouts/main.tpl"}

{block name="title"}
    {$category.name}
{/block}

{block name="content"}
    <h1>
        {$category.name}
    </h1>
    <p>
        {$category.description}
    </p>
    <div class="category">
        <div class="category__list">
            {foreach $articles as $article}
                <div class="card">
                    <div class="card_image">
                        <img src="/uploads/{$article.image}" alt="{$article.title}">
                    </div>

                    <h3>{$article.title} {$article.id}</h3>

                    <span class="date">{$article.date|date_format:"%B %e, %Y"}</span>

                    <p>{$article.description}</p>

                    <a href="/article/{$article.id}">Continue Reading</a>
                </div>
            {/foreach}
        </div>
    </div>

    {if $totalPages > 1}
        <div class="pagination">

            {section name=p loop=$totalPages}
                {assign var=page value=$smarty.section.p.index+1}

                <a href="?page={$page}"
                   class="{if $page == $currentPage}active{/if}">
                    {$page}
                </a>

            {/section}

        </div>
    {/if}

{/block}