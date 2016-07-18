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
     * @param  string|null $key
     * @param  mixed|null $default
     * @return Settings
     */
    public function settings($key = null, $default = null)
    {
        return $key ? $this->settings()->get($key, $default) : new Settings($this);
    }
}