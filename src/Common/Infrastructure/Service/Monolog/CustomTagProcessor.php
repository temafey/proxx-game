<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\Monolog;

use Error;
use MicroModule\Base\Domain\Exception\AlertException;
use MicroModule\Base\Domain\Exception\CriticalException;
use MicroModule\Base\Domain\Exception\EmergencyException;
use Monolog\Processor\ProcessorInterface;
use RuntimeException;
use Throwable;
use TypeError;

class CustomTagProcessor implements ProcessorInterface
{
    protected const EXCEPTION_NAME_ALERT = 'Alert';
    protected const EXCEPTION_NAME_CRITICAL = 'Critical';
    protected const EXCEPTION_NAME_EMERGENCY = 'Emergency';
    protected const EXCEPTION_NAME_RUNTIME = 'Runtime';
    protected const EXCEPTION_NAME_DEFAULT = 'Exception';
    protected const ERROR_BASE_NAME = 'Error';
    protected const ERROR_NAME_TYPE = 'TypeError';

    /**
     * Application environment prod|test|stage|prod
     */
    protected string $environment;

    /**
     * Application release tag
     */
    protected string $release;

    /**
     * Logging tags
     */
    protected array $tags;

    /**
     * Global logging tags from application and environment
     */
    protected array $globalTags;

    /**
     * Additional tags
     *
     * @var string[]
     */
    protected array $additionalTags;

    /**
     * @param string[] $additionalTags
     */
    public function __construct(
        string $environment,
        string $release,
        array $globalTags = [],
        array $additionalTags = []
    ) {
        $this->environment = $environment;
        $this->release = $release;
        $this->globalTags = $globalTags;
        $this->additionalTags = $additionalTags;
    }

    /**
     * Add custom tags to log tags. Method called by Monolog
     */
    public function __invoke(array $record): array
    {
        $this->addAdditionalTags($record);
        $this->addGlobalTags($record);
        $record['extra']['tags'] = $this->tags;
        $record['extra']['release'] = $this->release;
        $record['extra']['environment'] = $this->environment;

        return $record;
    }

    /**
     * Add global tags, such exception level, version of php, application name etc.
     */
    protected function addGlobalTags(array $record): void
    {
        $context = $record['context'];
        if (isset($context['exception'])) {
            $this->addTag('exception_type', $this->resolveExceptionLevelType($context['exception']));
        }

        $this->addTag('php_version', (string)phpversion());

        foreach ($this->globalTags as $k => $v) {
            $this->addTag($k, $v);
        }
    }

    /**
     * Add logging additional tags
     */
    protected function addAdditionalTags(array $record): void
    {
        $context = $record['context'];

        foreach ($this->additionalTags as $key) {
            if (isset($context[$key])) {
                $this->addTag($key, $context[$key]);
            }
        }
    }

    /**
     * Add logging tag.
     *
     * @param object|mixed[]|string|int $value
     */
    protected function addTag(string $key, $value): void
    {
        if (is_object($value)) {
            $value = method_exists($value, 'normalize')
                ? json_encode($value->normalize()) : var_export($value, true);
        }
        $this->tags[$key] = $value;
    }

    /**
     * Resolve exception level type based on exception.
     */
    protected function resolveExceptionLevelType(Throwable $e): string
    {
        return match (true) {
            $e instanceof AlertException => self::EXCEPTION_NAME_ALERT,
            $e instanceof CriticalException => self::EXCEPTION_NAME_CRITICAL,
            $e instanceof EmergencyException => self::EXCEPTION_NAME_EMERGENCY,
            $e instanceof RunTimeException => self::EXCEPTION_NAME_RUNTIME,
            $e instanceof TypeError => self::ERROR_NAME_TYPE,
            $e instanceof Error => self::ERROR_BASE_NAME,
            default => self::EXCEPTION_NAME_DEFAULT,
        };
    }
}
