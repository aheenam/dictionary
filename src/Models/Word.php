<?php

namespace Aheenam\Dictionary\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Word extends Model
{

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function translations()
	{
		return $this->hasMany(Translation::class);
	}

	/**
	 * @param string $query
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function search($query)
	{
		return $this
			->where('key', 'like', $query)
			->orWhereHas('translations', function (Builder $q) use ($query) {
				$q->where('key', 'like', '%'.$query.'%');
			})
			->get();
	}

	/**
	 * finds word by query
	 *
	 * @param string $query
	 *
	 * @return Word|Model
	 */
	public function word($query)
	{
		return $this
			->where('key', 'like', $query)
			->first();
	}

	/**
	 * @param $languageCode
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|Translation
	 */
	public function in($languageCode)
	{
		$translations = $this
			->translations()
			->where('language', $languageCode)
			->get();

		if ($translations->count() === 0)
			return null;

		if ($translations->count() === 1)
			return $translations->first();

		return $translations;
	}

}