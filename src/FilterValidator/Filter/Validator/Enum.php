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

class Enum implements ValidatorInterface
{
    public function validate(string $name, array $filterDescription, Request $request): array
    {
        $value = $request->query->get($name);
        if (empty($value) && '0' !== $value || !\is_string($value)) {
            return [];
        }

        $enum = $filterDescription['swagger']['enum'] ?? null;

        if (null !== $enum && !\in_array($value, $enum, true)) {
            return [
                \sprintf('Query parameter "%s" must be one of "%s"', $name, implode(', ', $enum)),
            ];
        }

        return [];
    }
}
