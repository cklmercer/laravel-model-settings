<?php

namespace Cklmercer\ModelSettings;

trait HasSettings
{
    /**
     * Get the settings attribute.
     *
     * @param  json $settings
     * @return mixed
     */
    public function getSettingsAttribute($settings)
    {
        return json_decode($settings, true);
    }

    /**
     * Set the settings attribute.
     *
     * @param  $settings
     * @return void
     */
    public function setSettingsAttribute($settings)
    {
        $this->attributes['settings'] = json_encode($settings);
    }

    /**
     * The model's settings.
     *
     * @param  null $key
     * @return Settings
     */
    public function settings($key = null)
    {
        return $key ? $this->settings()->get($key) : new Settings($this);
    }
}