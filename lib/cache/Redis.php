<?php
namespace ActiveRecord;

class Redis
{
	private $cache_control;

	/**
	 * Creates a Redis instance.
	 *
	 * Takes an $options array w/ the following parameters:
	 *
	 * <ul>
	 * <li><b>host:</b> host for the cache_control server </li>
	 * <li><b>port:</b> port for the cache_control server </li>
	 * </ul>
	 * @param array $options
	 */
	public function __construct($options)
	{
        $this->cache_control = new \FoxyCart\SharedComponents\Cache\CacheControl('redis', ['obj' => $options]);
	}

	public function flush()
	{
		$this->cache_control->flush();
	}

	public function read($key)
	{
		$result = $this->cache_control->get($key);
		return $result['item'];
	}

	public function write($key, $value, $expire = 30)
	{
		$this->cache_control->set($key,
            [
                'last_modified' => time(),
                'item' => $value
            ],
            $expire
        );
	}

	public function delete($key)
	{
		$this->cache_control->delete($key);
	}
}
