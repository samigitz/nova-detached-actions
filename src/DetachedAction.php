<?php

namespace Datomatic\Nova\Tools\DetachedActions;

use Laravel\Nova\Nova;
use Illuminate\Support\Arr;
use Laravel\Nova\Actions\Action;

abstract class DetachedAction extends Action
{
    public $onlyOnIndex = false;
    public $onlyOnDetail = false;
    public $showOnIndex = false;
    public $showOnDetail = false;
    public $standalone = true;

    /**
     * Extra CSS classes to apply to detached action button.
     */
    public string $extraClasses = '';

    /**
     * Default CSS classes to apply to detached action button.
     */
    public string $defaultClasses = 'hover:bg-gray-200 dark:hover:bg-gray-900 flex-shrink-0 rounded focus:outline-none focus:ring inline-flex items-center font-bold px-3 h-9 text-sm flex-shrink-0';

    /**
     * The icon type.
     *
     * @var string
     */
    public $icon = '';

    /**
     * CSS classes to customize the display of an icon in a button.
     */
    public string $iconClasses = '';

    /**
     * Set the extra CSS classes to be applied to the detached action button.
     */
    public function extraClasses(string $classes): self
    {
        $this->extraClasses = $this->prepareClasses($classes);

        return $this;
    }

    /**
     * Get the display classes for the detached action button.
     */
    public function getClasses(): string
    {
        return $this->prepareClasses($this->defaultClasses . ' ' . $this->extraClasses);
    }

    public function icon($type)
    {
        $this->icon = $type;

        return $this;
    }

    public function iconClasses(string $classes): self
    {
        $this->iconClasses = $this->prepareClasses($classes);

        return $this;
    }

    /**
     * Prepare the classes so that a string or an array of strings is formatted correctly.
     */
    protected function prepareClasses(string $classes): string
    {
        return trim(preg_replace('/\s+/', ' ', $classes));
    }

    /**
     * Prepare the action for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge([
            'detachedAction' => true,
            'classes' => $this->getClasses(),
            'icon' => $this->icon,
            'iconClasses' => $this->iconClasses,
        ], parent::jsonSerialize(), $this->meta());
    }
}
