<?php

namespace Datomatic\Nova\Tools\DetachedActions;

use Laravel\Nova\Nova;
use Illuminate\Support\Arr;
use Laravel\Nova\Actions\Action;

abstract class DetachedAction extends Action
{
    /**
     * Indicates if this action is only available on the custom index toolbar.
     *
     * @var bool
     */
    public $showOnIndexToolbar = true;
    public $onlyOnIndex = false;
    public $onlyOnDetail = false;
    public $showOnIndex = false;
    public $showOnDetail = false;
    public $showOnTableRow = false;
    public $standalone = true;

    /**
     * Extra CSS classes to apply to detached action button.
     *
     * @var array
     */
    public $extraClasses = [];


    /**
     * Default CSS classes to apply to detached action button.
     *
     * @var array
     */
    public $defaultClasses = ['hover:bg-gray-200 dark:hover:bg-gray-800 flex-shrink-0 rounded focus:outline-none focus:ring inline-flex items-center font-bold px-3 h-9 text-sm flex-shrink-0'];

    /**
     * The icon type.
     *
     * @var string
     */
    public $icon = '';

    /**
     * CSS classes to customize the display of an icon in a button.
     *
     * @var string
     */
    public $iconClasses = '';

    /**
     * Determine if the action is to be shown on the custom index toolbar.
     *
     * @return bool
     */
    public function shownOnIndexToolbar()
    {
        return $this->showOnIndexToolbar;
    }

    /**
     * Set the extra CSS classes to be applied to the detached action button.
     *
     * @param mixed $classes
     * @return $this
     */
    public function extraClasses($classes)
    {
        $this->extraClasses = $this->prepareClasses(Arr::wrap($classes));

        return $this;
    }


    /**
     * Get the display classes for the detached action button.
     *
     * @return array
     */
    public function getClasses()
    {
        return $this->prepareClasses(array_merge(
            Arr::wrap($this->defaultClasses),
            $this->extraClasses
        ));
    }

    public function icon($type)
    {
        $this->icon = $type;

        return $this;
    }

    public function iconClasses($classes)
    {
        $this->iconClasses = $this->prepareClasses($classes);

        return $this;
    }

    /**
     * Prepare the classes so that a string or an array of strings is formatted correctly.
     *
     * @param string|array $classes
     *
     * @return array
     */
    protected function prepareClasses($classes)
    {
        return array_filter(array_map('trim', Arr::wrap($classes)));
    }

    /**
     * Prepare the action for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize() :array
    {
        return array_merge([
            'detachedAction' => true,
            'showOnIndexToolbar' => $this->shownOnIndexToolbar(),
            'classes' => $this->getClasses(),
            'icon' => $this->icon,
            'iconClasses' => $this->iconClasses,
        ], parent::jsonSerialize(), $this->meta());
    }
}
