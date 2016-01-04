<?php
/**
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2
 * @license
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 * @link http://phpwhois.pw
 * @copyright Copyright (c) 2015 Dmitry Lukashin
 */

namespace phpWhois;

use phpWhois\Query;
use phpWhois\Provider\ProviderAbstract;

/**
 * Response from WhoisServer
 */
class Response
{
    /**
     * @var Query
     */
    private $query;


    /**
     * @var string Raw data received from whois server
     */
    private $raw;

    /**
     * @var array Parsed
     */
    private $parsed;

    /**
     * Response constructor
     *
     * @param Query $query
     */
    public function __construct(Query $query = null)
    {
        $this->setQuery($query);
    }

    /**
     * Set not parsed raw response from the whois server
     *
     * @var string  $raw
     *
     * @return $this
     */
    public function setRaw($raw = null)
    {
        $this->raw = $raw;

        return $this;
    }

    /**
     * Get not parsed raw response from whois server
     *
     * @return null|string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Set query
     *
     * @param Query $query
     *
     * @return $this
     */
    public function setQuery(Query $query = null)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get current query object
     *
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set parsed
     *
     * @param array $parsed
     *
     * @return $this
     */
    public function setParsed(array $parsed = [])
    {
        $this->parsed = $parsed;

        return $this;
    }

    /**
     * Get parsed array
     *
     * @return array
     */
    public function getParsed()
    {
        return $this->parsed;
    }

    /**
     * Look for the key in the rows array
     *
     * @param $key
     *
     * @return mixed|null
     */
    public function getByKey($key)
    {
        $parsed = $this->getParsed();

        if (array_key_exists('rows', $parsed) && array_key_exists($key, $parsed['rows'])) {
            return $parsed['rows'][$key];
        }

        return null;
    }

    public function getData()
    {
        $result = [
            'query' => [
                'address' => $this->query->getAddress(),
                'addressOrig' => $this->query->getAddressOrig(),
            ],
            'server' => [
                'name' => $this->provider->getServer(),
                'port' => $this->provider->getPort(),
                'errno' => $this->provider->getConnectionErrNo(),
                'errstr' => $this->provider->getConnectionErrStr(),
            ],
            'responseRaw' => $this->getRaw(),
        ];
        return $result;
    }

    public function getJson()
    {
        return json_encode($this->getData());
    }
}