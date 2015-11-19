<?php

Class Controller_Pages extends Controller {
    public function action_terms() {
        $view = View::forge('home/base_layout');
        $view->css = View::forge('home/layout/css');
        $view->meta = View::forge('home/layout/meta');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/terms', array());

        return $view;
    }

    public function get_pricing() {
        $view = View::forge('home/base_layout');
        $view->css = View::forge('home/layout/css');
        $view->meta = View::forge('home/layout/meta');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/pricing', array());

        return $view;
    }

    public function get_guide($slug = NULL) {
        if (is_null($slug))
            \Response::redirect(\Uri::create('docs/introduction'));

        $list = \DB::select('title', 'slug')->from('pages')->where('type', 'getting-started')->and_where('published', 1)->order_by('position', 'ASC')->cached(3600 * 30)->execute('frontend')->as_array();
        $curr_page = \DB::select()->from('pages')->where('slug', $slug)->and_where('type', 'getting-started')->and_where('published', 1)->cached(3600 * 30)->execute('frontend');

        $view = View::forge('home/base_layout');
        $view->css = View::forge('home/layout/css');
        $view->meta = View::forge('home/layout/meta');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/guide', array(
            'doc_list' => $list,
            'page'     => $curr_page,
            'slug'     => $slug
        ), FALSE);

        return $view;
    }
}