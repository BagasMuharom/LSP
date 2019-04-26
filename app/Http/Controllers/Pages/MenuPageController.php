<?php

namespace App\Http\Controllers\Pages;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:menu'
        ]);
    }

    public function index()
    {
        $icons = ['icon-user', 'icon-people', 'icon-user-female', 'icon-user-follow', 'icon-user-following', 'icon-user-unfollow', 'icon-login', 'icon-logout', 'icon-emotsmile', 'icon-phone', 'icon-call-end', 'icon-call-in', 'icon-call-out', 'icon-map', 'icon-location-pin', 'icon-direction', 'icon-directions', 'icon-compass', 'icon-layers', 'icon-menu', 'icon-list', 'icon-options-vertical', 'icon-options', 'icon-arrow-down', 'icon-arrow-left', 'icon-arrow-right', 'icon-arrow-up', 'icon-arrow-up-circle', 'icon-arrow-left-circle', 'icon-arrow-right-circle', 'icon-arrow-down-circle', 'icon-check', 'icon-clock', 'icon-plus', 'icon-minus', 'icon-close', 'icon-event', 'icon-exclamation', 'icon-organization', 'icon-trophy', 'icon-screen-smartphone', 'icon-screen-desktop', 'icon-plane', 'icon-notebook', 'icon-mustache', 'icon-mouse', 'icon-magnet', 'icon-energy', 'icon-disc', 'icon-cursor', 'icon-cursor-move', 'icon-crop', 'icon-chemistry', 'icon-speedometer', 'icon-shield', 'icon-screen-tablet', 'icon-magic-wand', 'icon-hourglass', 'icon-graduation', 'icon-ghost', 'icon-game-controller', 'icon-fire', 'icon-eyeglass', 'icon-envelope-open', 'icon-envelope-letter', 'icon-bell', 'icon-badge', 'icon-anchor', 'icon-wallet', 'icon-vector', 'icon-speech', 'icon-puzzle', 'icon-printer', 'icon-present', 'icon-playlist', 'icon-pin', 'icon-picture', 'icon-handbag', 'icon-globe-alt', 'icon-globe', 'icon-folder-alt', 'icon-folder', 'icon-film', 'icon-feed', 'icon-drop', 'icon-drawer', 'icon-docs', 'icon-doc', 'icon-diamond', 'icon-cup', 'icon-calculator', 'icon-bubbles', 'icon-briefcase', 'icon-book-open', 'icon-basket-loaded', 'icon-basket', 'icon-bag', 'icon-action-undo', 'icon-action-redo', 'icon-wrench', 'icon-umbrella', 'icon-trash', 'icon-tag', 'icon-support', 'icon-frame', 'icon-size-fullscreen', 'icon-size-actual', 'icon-shuffle', 'icon-share-alt', 'icon-share', 'icon-rocket', 'icon-question', 'icon-pie-chart', 'icon-pencil', 'icon-note', 'icon-loop', 'icon-home', 'icon-grid', 'icon-graph', 'icon-microphone', 'icon-music-tone-alt', 'icon-music-tone', 'icon-earphones-alt', 'icon-earphones', 'icon-equalizer', 'icon-like', 'icon-dislike', 'icon-control-start', 'icon-control-rewind', 'icon-control-play', 'icon-control-pause', 'icon-control-forward', 'icon-control-end', 'icon-volume-1', 'icon-volume-2', 'icon-volume-off', 'icon-calendar', 'icon-bulb', 'icon-chart', 'icon-ban', 'icon-bubble', 'icon-camrecorder', 'icon-camera', 'icon-cloud-download', 'icon-cloud-upload', 'icon-envelope', 'icon-eye', 'icon-flag', 'icon-heart', 'icon-info', 'icon-key', 'icon-link', 'icon-lock', 'icon-lock-open', 'icon-magnifier', 'icon-magnifier-add', 'icon-magnifier-remove', 'icon-paper-clip', 'icon-paper-plane', 'icon-power', 'icon-refresh', 'icon-reload', 'icon-settings', 'icon-star', 'icon-symbol-female', 'icon-symbol-male', 'icon-target', 'icon-credit-card', 'icon-paypal', 'icon-social-tumblr', 'icon-social-twitter', 'icon-social-facebook', 'icon-social-instagram', 'icon-social-linkedin', 'icon-social-pinterest', 'icon-social-github', 'icon-social-google', 'icon-social-reddit', 'icon-social-skype', 'icon-social-dribbble', 'icon-social-behance', 'icon-social-foursqare', 'icon-social-soundcloud', 'icon-social-spotify', 'icon-social-stumbleupon', 'icon-social-youtube', 'icon-social-dropbox', 'icon-social-vkontakte', 'icon-social-steam'];

        return view('menu.menu.index', [
            'menu' => Menu::findByRoute(Menu::MENU),
            'data' => Menu::orderBy('nama')->paginate(10),
            'icons' => $icons,
            'no' => 0
        ]);
    }
}