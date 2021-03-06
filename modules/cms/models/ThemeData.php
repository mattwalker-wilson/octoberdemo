<?php namespace Cms\Models;

use Lang;
use Model;
use Event;
use Cms\Classes\Theme as CmsTheme;
use System\Classes\CombineAssets;
use System\Models\File;
use Exception;

/**
 * ThemeData for theme customization
 *
 * @package october\cms
 * @author Alexey Bobkov, Samuel Georges
 */
class ThemeData extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cms_theme_data';

    /**
     * @var array guarded fields
     */
    protected $guarded = [];

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = ['data'];

    /**
     * @var array rules to be applied to the data.
     */
    public $rules = [];

    /**
     * @var array customMessages to be applied to the data.
     */
    public $customMessages = [];

    /**
     * @var array attributeNames to be applied to the data.
     */
    public $attributeNames = [];

    /**
     * @var array attachOne relations
     */
    public $attachOne = [];

    /**
     * @var ThemeData instances of cached objects
     */
    protected static $instances = [];

    /**
     * beforeSave the model, strip dynamic attributes applied from config.
     */
    public function beforeSave()
    {
        /*
         * Dynamic attributes are stored in the jsonable attribute 'data'.
         */
        $staticAttributes = ['id', 'theme', 'data', 'created_at', 'updated_at'];
        $dynamicAttributes = array_except($this->getAttributes(), $staticAttributes);

        $this->data = $dynamicAttributes;
        $this->setRawAttributes(array_only($this->getAttributes(), $staticAttributes));
    }

    /**
     * afterSave clear asset cache after saving to ensure `assetVar` form fields take
     * immediate effect.
     */
    public function afterSave()
    {
        try {
            CombineAssets::resetCache();
        }
        catch (Exception $ex) {
        }
    }

    /**
     * forTheme returns a cached version of this model, based on a Theme object
     */
    public static function forTheme(CmsTheme $theme): ThemeData
    {
        $dirName = $theme->getDirName();
        if ($themeData = array_get(self::$instances, $dirName)) {
            return $themeData;
        }

        try {
            $themeData = static::createThemeDataModel()->firstOrCreate(['theme' => $dirName]);
        }
        catch (Exception $ex) {
            // Database failed
            $themeData = static::createThemeDataModel(['theme' => $dirName]);
        }

        return self::$instances[$dirName] = $themeData;
    }

    /**
     * After fetching the model, intiialize model relationships based
     * on form field definitions.
     * @return void
     */
    public function afterFetch()
    {
        $data = (array) $this->data + $this->getDefaultValues();

        /*
         * Repeater form fields store arrays and must be jsonable.
         */
        foreach ($this->getFormFields() as $id => $field) {
            if (!isset($field['type'])) {
                continue;
            }

            if (in_array($field['type'], ['repeater', 'nestedform'])) {
                $this->jsonable[] = $id;
            }
            elseif ($field['type'] === 'fileupload') {
                $this->attachOne[$id] = File::class;
                unset($data[$id]);
            }
        }

        /*
         * Fill this model with the jsonable attributes kept in 'data'.
         */
        $this->setRawAttributes((array) $this->getAttributes() + $data, true);
    }

    /**
     * Before model is validated, set the default values.
     * @return void
     */
    public function beforeValidate()
    {
        if (!$this->exists) {
            $this->setDefaultValues();
        }
    }

    /**
     * Creates relationships for this model based on form field definitions.
     */
    public function initFormFields()
    {
    }

    /**
     * Sets default values on this model based on form field definitions.
     */
    public function setDefaultValues()
    {
        foreach ($this->getDefaultValues() as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }

    /**
     * Gets default values for this model based on form field definitions.
     * @return array
     */
    public function getDefaultValues()
    {
        $result = [];

        foreach ($this->getFormFields() as $attribute => $field) {
            if (($value = array_get($field, 'default')) === null) {
                continue;
            }

            $result[$attribute] = $value;
        }

        return $result;
    }

    /**
     * Returns all fields defined for this model, based on form field definitions.
     * @return array
     */
    public function getFormFields()
    {
        if (!$theme = CmsTheme::load($this->theme)) {
            throw new Exception(Lang::get('Unable to find theme with name :name', $this->theme));
        }

        $config = $theme->getFormConfig();

        return array_get($config, 'fields', []) +
            array_get($config, 'tabs.fields', []) +
            array_get($config, 'secondaryTabs.fields', []);
    }

    /**
     * Returns variables that should be passed to the asset combiner.
     * @return array
     */
    public function getAssetVariables()
    {
        $result = [];

        foreach ($this->getFormFields() as $attribute => $field) {
            if (!$varName = array_get($field, 'assetVar')) {
                continue;
            }

            $result[$varName] = $this->{$attribute};
        }

        return $result;
    }

    /**
     * applyAssetVariablesToCombinerFilters that support it
     */
    public static function applyAssetVariablesToCombinerFilters($filters)
    {
        $theme = CmsTheme::getActiveTheme();

        if (!$theme) {
            return;
        }

        if (!$theme->hasCustomData()) {
            return;
        }

        $assetVars = $theme->getCustomData()->getAssetVariables();

        foreach ($filters as $filter) {
            if (method_exists($filter, 'setPresets')) {
                $filter->setPresets($assetVars);
            }
        }
    }

    /**
     * getCombinerCacheKey generates a cache key for the combiner, this allows variables to
     * bust the cache.
     * @return string
     */
    public static function getCombinerCacheKey()
    {
        $theme = CmsTheme::getActiveTheme();
        if (!$theme->hasCustomData()) {
            return '';
        }

        $customData = $theme->getCustomData();

        return (string) $customData->updated_at ?: '';
    }

    /**
     * createThemeDataModel is an opportunity to override the theme data model
     */
    public static function createThemeDataModel(array $attributes = []): ThemeData
    {
        /**
         * @event cms.theme.createThemeDataModel
         * Overrides the theme data model used by the system, which must inherit the main model
         *
         * Example usage:
         *
         *     Event::listen('cms.theme.createThemeDataModel', function (array $attributes) {
         *         return new MyCustomThemeDataModel($attributes);
         *     });
         */
        if ($newModel = Event::fire('cms.theme.createThemeDataModel', [$attributes], true)) {
            if ($newModel instanceof ThemeData) {
                return $newModel;
            }
        }

        return new static($attributes);
    }
}
