<?php

namespace Cklmercer\ModelSettings;

trait HasSettings
{
    /**
     * Boot the HasSettings trait.
     *
     * @return void
     */
    public static function bootHasSettings()
    {
        self::creating(function ($model) {
            if (! $model->settings) {
                $model->settings = $model->getDefaultSettings();
            }
        });

        self::saving(function ($model) {
            if ($model->settings && property_exists($model, 'allowedSettings') && is_array($model->allowedSettings)) {
                $model->settings = array_only($model->settings, $model->allowedSettings);
            }
        });
    }

    /**
     * Get the model's default settings.
     *
     * @return array
     */
    public function getDefaultSettings()
    {
        return (isset($this->defaultSettings) && is_array($this->defaultSettings))
            ? $this->defaultSettings
            : [];
    }

    /**
     * Get the settings attribute.
     *
     * @param json $settings
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
     * @param string|null $key
     * @param mixed|null  $default
     * @return Settings
     */
    public function settings($key = null, $default = null)
    {
        return $key ? $this->settings()->get($key, $default) : new Settings($this);
    }
    
    /**
     * Map settings() to another alias specified with $mapSettingsTo.
     * 
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (isset($this->mapSettingsTo) && $name == $this->mapSettingsTo) {
            return $this->settings(...$args);
        }

        return is_callable(['parent', '__call'])
            ? parent::__call($name, $args) 
            : null;
    }
}
