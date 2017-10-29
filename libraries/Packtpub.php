<?php

namespace PacktpubDaily\libraries;

use PacktpubDaily\libraries\RequestManager;
use PacktpubDaily\libraries\Config;

/**
 * Class Packtpub
 * @package PacktpubDaily\libraries
 */
class Packtpub
{
    /**
     * Request Manager
     */
    private $rm;
    private $email;
    private $password;

    public function __construct()
    {
        $this->email = Config::get('credentials.email');
        $this->password = Config::get('credentials.password');
        $this->rm = new RequestManager(Config::get('url.base'));
    }

    private function _isLoggedIn($htmlSource)
    {
        $isLogged = true;
        $htmlDom = str_get_html($htmlSource);
        $loggedIn = $htmlDom->find('div[id=main-container]', 0);
        $classes = $loggedIn->getAttribute('class');

        if(strpos($classes, "not-logged-in") !== false) {
            $isLogged = false;
        }

        return $isLogged;
    }

    /**
     * @param FreeBook $book
     * @throws \Exception
     */
    public function claim(FreeBook $book)
    {
        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'op' => 'Login',
            'form_build_id' => $book->formId,
            'form_id' => 'packt_user_login_form'
        ];
        $response = $this->rm->post(Config::get('url.free_learning'), $data);

        if ($this->_isLoggedIn($response)) {
            $claimed = $this->rm->post(Config::get('url.free_learning') . $book->url);
            if ($claimed) {
                // TODO: Send a notification by email to user account
                echo 'Congrats! You have the new Book' . PHP_EOL;
            } else {
                throw new \Exception('Can not posible to claim the freebok, sorry.');
            }
        } else {
            throw new \Exception('Can not posible to loggin on the system, check out please.');
        }

    }

    /**
     * @return null|FreeBook
     */
    public function getDailyFreeBook()
    {
        $freeBook = null;
        $html = file_get_html(Config::get('url.base') . Config::get('url.free_learning'));
        if (!empty($html)) {
            try {
                $image = $html->find('img[class=bookimage]', 0)->attr['src'];
                $title = trim($html->find('div[class=dotd-title] h2', 0)->plaintext);
                $formId = $html->find('input[name=form_build_id]', 0)->attr['id'];
                $url = $html->find('div[class=free-ebook] form', 0)->attr['action'];
                $freeBook = new FreeBook($title, $image, $formId, $url);
            } catch (\Exception $e) {
                echo 'Can fill the daily FreeBook for one reasons: the method to show the new book and its tags has changed';
            }

        }
        return $freeBook;
    }
}