<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatformFilterValidator\ApiPlatform\Core\Filter\Validator;

use Symfony\Component\HttpFoundation\Request;

class MultipleOf implements ValidatorInterface
{
    public function validate(string $name, array $filterDescription, Request $request): array
    {
        $value = $request->query->get($name);
        if (empty($value) && '0' !== $value || !\is_string($value)) {
            return [];
        }

        $multipleOf = $filterDescription['swagger']['multipleOf'] ?? null;

        if (null !== $multipleOf && 0 !== ($value % $multipleOf)) {
            return [
                \sprintf('Query parameter "%s" must multiple of %s', $name, $multipleOf),
            ];
        }

        return [];
    }
}
