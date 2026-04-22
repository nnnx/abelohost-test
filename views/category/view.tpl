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
        <div class="category__sort">
            <a href="?sort=date&page={$currentPage}"
               class="{if $sort == 'date'}active{/if}">
                По дате
            </a>

            <a href="?sort=views&page={$currentPage}"
               class="{if $sort == 'views'}active{/if}">
                По просмотрам
            </a>
        </div>
        <div class="category__list">
            {foreach $articles as $article}
                <div class="card">
                    <div class="card_image">
                        <img src="/uploads/{$article.image}" alt="{$article.title}">
                    </div>

                    <h3>{$article.title} {$article.id}</h3>

                    <span class="date">{$article.date|date_format:"%B %e, %Y"}</span>

                    <div class="views">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#000000"><g fill="none" stroke="#000000" stroke-linejoin="round" stroke-width="1.5"><path d="M3.182 12.808C4.233 14.613 7.195 18.81 12 18.81c4.813 0 7.77-4.199 8.82-6.002a1.6 1.6 0 0 0-.001-1.615C19.769 9.389 16.809 5.19 12 5.19s-7.768 4.197-8.818 6.001a1.6 1.6 0 0 0 0 1.617Z"/><path d="M12 14.625a2.625 2.625 0 1 0 0-5.25a2.625 2.625 0 0 0 0 5.25Z"/></g></svg>
                        <span>{$article.views}</span>
                    </div>

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

                <a href="?page={$page}&sort={$sort}"
                   class="{if $page == $currentPage}active{/if}">
                    {$page}
                </a>

            {/section}

        </div>
    {/if}

{/block}