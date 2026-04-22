<?php

declare(strict_types=1);

namespace Core;

use Smarty;

/**
 * Работа с представлениями (Smarty)
 */
class View
{
    /**
     * Рендер шаблона
     *
     * @param string $view путь без .tpl
     * @param array<string, mixed> $params
     * @return void
     * @throws \SmartyException
     */
    public static function render(string $view, array $params = []): void
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir(__DIR__ . '/../views/');
        $smarty->setCompileDir(__DIR__ . '/../runtime/templates_c/');

        foreach ($params as $key => $value) {
            $smarty->assign($key, $value);
        }

        $smarty->display($view . '.tpl');
    }
}