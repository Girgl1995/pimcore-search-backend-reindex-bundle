<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\EventSubscriber;

use Pimcore\Event\BundleManager\PathsEvent;
use Pimcore\Event\BundleManagerEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminAssetSubscriber implements EventSubscriberInterface
{
    private const JS_PATHS_EVENT  = 'onJsPaths';
    private const CSS_PATHS_EVENT = 'onCssPaths';

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            BundleManagerEvents::JS_PATHS  => self::JS_PATHS_EVENT,
            BundleManagerEvents::CSS_PATHS => self::CSS_PATHS_EVENT,
        ];
    }

    /**
     * @param PathsEvent $event
     * @return void
     */
    public function onJsPaths(PathsEvent $event): void
    {
        $event->addPaths([
            '/bundles/pimcoresearchbackendreindex/js/menuItem.js',
            '/bundles/pimcoresearchbackendreindex/js/startup.js'
        ]);
    }

    /**
     * @param PathsEvent $event
     * @return void
     */
    public function onCssPaths(PathsEvent $event): void
    {
        $event->addPaths([
            '/bundles/pimcoresearchbackendreindex/css/reindexButton.css'
        ]);
    }
}
