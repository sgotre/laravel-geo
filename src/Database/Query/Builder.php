<?php

namespace Karomap\GeoLaravel\Database\Query;

use CrEOF\Geo\WKB\Parser as WKBParser;
use Illuminate\Database\Query\Builder as IlluminateBuilder;
use Karomap\PHPOGC\OGCObject;

class Builder extends IlluminateBuilder
{
    /**
     * @param $column
     * @param $value
     * @param string $boolean
     * @param bool   $not
     *
     * @return $this
     */
    public function whereEquals($column, OGCObject $value, $boolean = 'and', $not = false)
    {
        $type = $not ? 'NotEquals' : 'Equals';

        $this->wheres[] = compact('type', 'column', 'value', 'boolean');

        return $this;
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function whereNotEquals($column, OGCObject $value)
    {
        return $this->whereEquals($column, $value, 'and', true);
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereEquals($column, OGCObject $value)
    {
        return $this->whereEquals($column, $value, 'or');
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereNotEquals($column, OGCObject $value)
    {
        return $this->whereEquals($column, $value, 'or', true);
    }

    /**
     * @param $column
     * @param $value
     * @param string $boolean
     * @param bool   $not
     *
     * @return $this
     */
    public function whereContains($column, OGCObject $value, $boolean = 'and', $not = false)
    {
        $type = $not ? 'NotContains' : 'Contains';

        $this->wheres[] = compact('type', 'column', 'value', 'boolean');

        return $this;
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function whereNotContains($column, OGCObject $value)
    {
        return $this->whereContains($column, $value, 'and', true);
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereContains($column, OGCObject $value)
    {
        return $this->whereContains($column, $value, 'or');
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereNotContains($column, OGCObject $value)
    {
        return $this->whereContains($column, $value, 'or', true);
    }

    /**
     * @param $column
     * @param $value
     * @param string $boolean
     * @param bool   $not
     *
     * @return $this
     */
    public function whereIntersects($column, OGCObject $value, $boolean = 'and', $not = false)
    {
        $type = $not ? 'NotIntersects' : 'Intersects';

        $this->wheres[] = compact('type', 'column', 'value', 'boolean');

        return $this;
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function whereNotIntersects($column, OGCObject $value)
    {
        return $this->whereIntersects($column, $value, 'and', true);
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereIntersects($column, OGCObject $value)
    {
        return $this->whereIntersects($column, $value, 'or');
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereNotIntersects($column, OGCObject $value)
    {
        return $this->whereIntersects($column, $value, 'or', true);
    }

    /**
     * @param $column
     * @param $value
     * @param string $boolean
     * @param bool   $not
     *
     * @return $this
     */
    public function whereTouches($column, OGCObject $value, $boolean = 'and', $not = false)
    {
        $type = $not ? 'NotTouches' : 'Touches';

        $this->wheres[] = compact('type', 'column', 'value', 'boolean');

        return $this;
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function whereNotTouches($column, OGCObject $value)
    {
        return $this->whereTouches($column, $value, 'and', true);
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereTouches($column, OGCObject $value)
    {
        return $this->whereTouches($column, $value, 'or');
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereNotTouches($column, OGCObject $value)
    {
        return $this->whereTouches($column, $value, 'or', true);
    }

    /**
     * @param $column
     * @param $value
     * @param string $boolean
     * @param bool   $not
     *
     * @return $this
     */
    public function whereOverlaps($column, OGCObject $value, $boolean = 'and', $not = false)
    {
        $type = $not ? 'NotOverlaps' : 'Overlaps';

        $this->wheres[] = compact('type', 'column', 'value', 'boolean');

        return $this;
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function whereNotOverlaps($column, OGCObject $value)
    {
        return $this->whereOverlaps($column, $value, 'and', true);
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereOverlaps($column, OGCObject $value)
    {
        return $this->whereOverlaps($column, $value, 'or');
    }

    /**
     * @param $column
     * @param  OGCObject $value
     * @return Builder
     */
    public function orWhereNotOverlaps($column, OGCObject $value)
    {
        return $this->whereOverlaps($column, $value, 'or', true);
    }

    /**
     * Get query result as GeoJSON.
     *
     * @param  string|string[] $geoms
     * @param  array           $columns
     * @throws \ErrorException
     * @return string
     */
    public function getGeoJson($geoms, $columns = ['*'])
    {
        $geoms = is_array($geoms) ? $geoms : [$geoms];

        if ($columns != ['*']) {
            $columns = array_values(array_unique(array_merge($columns, $geoms)));
        }

        $geoArray = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];
        $db = $this->getConnection();
        $parser = new WKBParser();

        foreach ($this->get($columns) as $row) {
            $row = get_object_vars($row);
            $properties = array_diff_key($row, array_flip($geoms));

            foreach ($geoms as $geom) {
                $parsed = $parser->parse($db->fromRawToWKB($row[$geom]));
                $geoArray['features'][] = [
                    'geometry' => [
                        'type' => OGCObject::getGeoJsonType($parsed['type']),
                        'coordinates' => $parsed['value'],
                    ],
                    'properties' => $properties,
                ];
            }
        }

        return json_encode($geoArray);
    }
}
