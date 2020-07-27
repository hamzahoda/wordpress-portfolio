<?php
/**
 * The template for displaying the Icons
 *
 * Template Name: Icons
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

get_header();
if(have_posts()): the_post();
    $sections = get_field('sections');
    $disable_paper_animation = kirki::get_option('certy_kirki_config','disable_paper_animation');
    ?>
    <div class="crt-paper-layers<?php if(empty($disable_paper_animation)):?> crt-animate<?php endif;?>">
        <div class="crt-paper clearfix">
            <div class="crt-paper-cont clear-mrg">
                <ul class="crt-icons-list clearfix">
                    <li><span class="crt-icon crt-icon-awards"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-awards"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-education"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-education"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-user-card"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-user-card"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-faq"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-faq"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-interests"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-interests"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-language"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-language"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-price"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-price"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-recom"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-recom"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-services"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-services"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-switcher"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-switcher"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-calendar"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-calendar"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-donation"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-donation"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-animal-lover"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-animal-lover"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-island"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-island"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-library"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-library"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bbq"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bbq"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-buddhism"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-buddhism"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-cafe"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-cafe"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-dentist"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-dentist"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-fast-food"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-fast-food"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-garden"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-garden"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-karaoke"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-karaoke"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-playground"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-playground"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-christian"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-christian"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-jewish"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-jewish"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-muslim"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-muslim"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-restaurant"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-restaurant"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-shop"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-shop"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-skiing"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-skiing"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-tennis"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-tennis"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-theatre"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-theatre"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bicycle"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bicycle"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chef"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chef"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-dancer"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-dancer"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-fishing"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-fishing"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-hiking"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-hiking"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-horse-riding"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-horse-riding"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-hunting"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-hunting"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-party"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-party"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-canoe"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-canoe"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-swimming"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-swimming"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-skydiving"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-skydiving"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-surfing"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-surfing"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-contact"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-contact"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-arrow-flat-left"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-arrow-flat-left"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-arrow-flat-right"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-arrow-flat-right"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-quote"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-quote"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-side-bar-icon"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-side-bar-icon"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-references"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-references"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-portfolio"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-portfolio"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-experience"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-experience"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-blog"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-blog"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-arrow-page-up"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-arrow-page-up"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-about"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-about"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-sports-shoe"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-sports-shoe"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bowling"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bowling"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-baseball"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-baseball"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-soccer-court"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-soccer-court"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-basketball"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-basketball"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-golf"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-golf"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-table-tennis"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-table-tennis"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-football"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-football"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-walk"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-walk"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chevron-thin-right"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chevron-thin-right"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chevron-thin-left"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chevron-thin-left"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chevron-thin-down"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chevron-thin-down"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-dots-three-horizontal"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-dots-three-horizontal"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-tv"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-tv"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bed"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bed"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-question"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-question"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-glass"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-glass"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-music"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-music"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-heart"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-heart"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-film"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-film"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-power-off"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-power-off"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-home"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-home"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-road"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-road"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-headphones"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-headphones"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-book"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-book"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-camera"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-camera"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-video-camera"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-video-camera"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-image"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-image"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-pencil"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-pencil"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-map"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-map"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-gift"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-gift"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-leaf"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-leaf"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-eye"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-eye"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-plane"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-plane"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-shopping"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-shopping"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-key"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-key"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-thumbs-up"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-thumbs-up"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-thumbs-down"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-thumbs-down"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-heart-o"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-heart-o"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-pin"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-pin"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-trophy"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-trophy"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-phone"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-phone"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-card"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-card"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-feed"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-feed"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bullhorn"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bullhorn"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-globe"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-globe"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-wrench"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-wrench"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-filter"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-filter"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-briefcase"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-briefcase"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-people"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-people"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chain"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chain"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-cloud"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-cloud"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-flask"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-flask"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-cut"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-cut"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-files"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-files"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-paperclip"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-paperclip"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-magic"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-magic"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-truck"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-truck"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-money"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-money"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-gavel"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-gavel"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-dashboard"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-dashboard"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-comment"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-comment"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-flash"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-flash"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-sitemap"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-sitemap"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-umbrella"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-umbrella"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-stethoscope"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-stethoscope"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-suitcase"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-suitcase"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bell"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bell"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-coffee"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-coffee"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-fighter-jet"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-fighter-jet"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-beer"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-beer"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-laptop"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-laptop"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-mobile-phone"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-mobile-phone"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-folder"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-folder"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-folder-open"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-folder-open"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-game"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-game"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-keyboard"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-keyboard"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-flag"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-flag"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-location-arrow"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-location-arrow"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-info"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-info"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-exclamation"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-exclamation"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-microphone"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-microphone"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-fire-extinguisher"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-fire-extinguisher"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-rocket"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-rocket"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-anchor"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-anchor"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-unlock"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-unlock"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-pagelines"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-pagelines"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-space-shuttle"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-space-shuttle"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-slack"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-slack"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bank"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bank"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-graduation-cap"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-graduation-cap"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-car"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-car"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-tree"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-tree"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-life-bouy"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-life-bouy"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-send-o"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-send-o"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-ball"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-ball"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-binoculars"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-binoculars"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-plug"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-plug"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-brush"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-brush"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-cake"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-cake"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-diamond"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-diamond"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-user-secret"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-user-secret"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-motorcycle"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-motorcycle"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-heartbeat"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-heartbeat"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-venus"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-venus"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-mars"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-mars"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-scale"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-scale"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-wheelchair"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-wheelchair"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-question-circle"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-question-circle"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-blind"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-blind"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-ad"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-ad"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-phone-volume"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-phone-volume"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-braille"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-braille"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-assistive-listening-systems"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-assistive-listening-systems"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-sign-language-o"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-sign-language-o"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-deaf"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-deaf"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-sign-language"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-sign-language"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-low-vision"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-low-vision"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-handshake"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-handshake"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-shower"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-shower"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-snowflake"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-snowflake"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-search"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-search"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-user"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-user"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-check"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-check"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-check"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-check"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-close"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-close"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-volume-up"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-volume-up"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chevron-left"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chevron-left"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chevron-right"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chevron-right"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chevron-up"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chevron-up"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-chevron-down"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-chevron-down"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-twitter"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-twitter"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-facebook"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-facebook"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-github"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-github"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-rss"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-rss"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-google-plus"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-google-plus"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-caret-down"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-caret-down"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-caret-up"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-caret-up"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-caret-left"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-caret-left"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-caret-right"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-caret-right"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-angle-up"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-angle-up"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-angle-down"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-angle-down"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-github-alt"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-github-alt"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-html5"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-html5"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-css3"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-css3"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-youtube"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-youtube"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-xing"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-xing"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-dropbox"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-dropbox"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-stack-overflow"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-stack-overflow"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-instagram"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-instagram"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-flickr"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-flickr"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bitbucket"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bitbucket"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-tumblr"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-tumblr"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-apple"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-apple"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-windows"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-windows"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-android"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-android"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-linux"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-linux"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-dribbble"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-dribbble"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-skype"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-skype"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-foursquare"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-foursquare"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-vk"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-vk"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-try"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-try"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-wordpress"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-wordpress"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-yahoo"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-yahoo"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-google"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-google"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-reddit"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-reddit"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-stumbleupon"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-stumbleupon"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-delicious"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-delicious"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-digg"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-digg"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-pied-piper"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-pied-piper"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-drupal"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-drupal"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-cube"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-cube"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-cubes"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-cubes"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-behance"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-behance"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-soundcloud"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-soundcloud"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-vine"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-vine"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-jsfiddle"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-jsfiddle"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-git"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-git"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-hacker-news"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-hacker-news"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-qq"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-qq"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-wechat"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-wechat"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-share"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-share"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-pinterest"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-pinterest"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-whatsapp"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-whatsapp"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-y-combinator"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-y-combinator"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-trademark"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-trademark"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-registered"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-registered"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-cc"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-cc"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-gg"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-gg"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-tripadvisor"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-tripadvisor"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-odnoklassniki"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-odnoklassniki"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-amazon"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-amazon"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-vimeo"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-vimeo"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-reddit-alien"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-reddit-alien"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-bluetooth"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-bluetooth"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-gitlab"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-gitlab"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-glide"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-glide"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-snapchat"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-snapchat"&gt;&lt;/span&gt;</span></li>
                    <li><span class="crt-icon crt-icon-yoast"></span><span class="crt-icon-class">&lt;span class="crt-icon crt-icon-yoast"&gt;&lt;/span&gt;</span></li>
                </ul>

            </div>
            <!-- .crt-paper-cont -->
        </div>
        <!-- .crt-paper -->
    </div>
    <!-- .crt-paper-layers -->
<?php endif;?>
<?php get_footer();?>
