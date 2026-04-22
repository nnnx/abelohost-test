{extends file="layouts/main.tpl"}

{block name="title"}
    Список категорий
{/block}

{block name="content"}

    {foreach $categories as $category}
        <div class="category">
            <div class="category__header">
                <h2>{$category.name}</h2>
                <a href="/category/{$category.id}">View All</a>
            </div>

            <div class="category__list">
                {foreach $category.articles as $article}
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
    {/foreach}

{/block}