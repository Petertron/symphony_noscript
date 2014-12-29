<?php

require_once TOOLKIT . '/class.administrationpage.php';

class contentExtensionSymphony_noscriptNoscript extends AdministrationPage
{
    public function __viewIndex()
    {
        $this->setTitle(__(('%1$s &ndash; %2$s'), array(__('Noscript'), __('Symphony'))));
        $this->appendSubheading(__('JavaScript Disabled'));
        $this->Contents->appendChild(
            new XMLElement(
                'noscript',
                new XMLElement(
                    'h2', __("To use Symphony, please enable JavaScript!")
                )
            )
        );
    }
}