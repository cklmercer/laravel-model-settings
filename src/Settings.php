<?php

namespace Cklmercer\ModelSettings;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Settings
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Settings constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the model's settings.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->model->settings ?? [];
    }

    /**
     * Apply the model's settings.
     *
     * @param array $settings
     * @return $this
     */
    public function apply($settings = []): self
    {
        $this->model->settings = (array) $settings;
        $this->model->save();

        return $this;
    }

    /**
     * Delete the setting at the given path.
     *
     * @param string|null $path
     * @return self
     */
    public function delete($path = null): self
    {
        if (! $path) {
            return $this->set();
        }

        $settings = $this->all();

        Arr::forget($settings, $path);

        return $this->apply($settings);
    }

    /**
     * Forget the setting at the given path.
     *
     * @alias delete()
     * @param string|null $path
     *
     * @return self
     */
    public function forget($path = null): self
    {
        return $this->delete($path);
    }

    /**
     * Return the value of the setting at the given path.
     *
     * @param string|null $path
     * @param mixed       $default
     *
     * @return mixed
     */
    public function get($path = null, $default = null)
    {
        return $path ? Arr::get($this->all(), $path, $default) : $this->all();
    }

    /**
     * Determine if the model has the given setting.
     *
     * @param string $path
     *
     * @return bool
     */
    public function has($path): bool
    {
        return Arr::has($this->all(), $path);
    }

    /**
     * Update the setting at given path to the given value.
     *
     * @param string|null $path
     * @param mixed       $value
     *
     * @return self
     */
    public function set($path = null, $value = []): self
    {
        if (func_num_args() < 2) {
            $value = $path;
            $path = null;
        }

        $settings = $this->all();

        Arr::set($settings, $path, $value);

        return $this->apply($settings);
    }

    /**
     * Update the setting at the given path if it exists.
     *
     * @alias  set()
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return self
     */
    public function update($path, $value): self
    {
        return $this->set($path, $value);
    }
}
