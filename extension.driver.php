<?php

class extension_Symphony_noscript extends Extension
{
    public function getSubscribedDelegates()
    {
        return array(
            array(
                'page' => '/backend/',
                'delegate' => 'AdminPagePostCallback',
                'callback' => 'adminPagePostCallback'
            ),
            array(
                'page' => '/backend/',
                'delegate' => 'AdminPagePreGenerate',
                'callback' => 'adminPagePreGenerate'
            )
        );
    }

    /**
    * Reroute "JavaScript Disabled" page
    */
    public function adminPagePostCallback(&$context)
    {
        //print_r($context);die;
        if ($context['callback']['driver'] == 'noscript') {
            $context['callback'] = array(
                'driver' => 'noscript',
                'driver_location' => EXTENSIONS . '/symphony_noscript/content/content.noscript.php',
                'pageroot' => '/extensions/symphony_noscript/content/',
                'classname' => 'contentExtensionSymphony_noscriptNoscript'
            );
        }
    }

    /**
    * Add 'noscript' tag to admin page unless current page is "JavaScript Disabled" page
    */
    public function adminPagePreGenerate(&$context)
    {
        $page = $context['oPage'];
        if (!is_object($page->Head)) return;

        $callback = Symphony::Engine()->getPageCallback();
        if ($callback['driver'] == 'noscript') return;

        // Modify page object
        $noscript = new XMLElement('noscript');
        $noscript->appendChild(
            new XMLElement(
                'meta',
                null,
                array(
                    'http-equiv' => 'refresh',
                    'content' => '0;URL=' . SYMPHONY_URL . '/noscript/'
                )
            )
        );
        $page->Head->prependChild($noscript);
    }
}