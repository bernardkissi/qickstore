<?php

declare(strict_types=1);

namespace Domain\Coupons\Services;

use Illuminate\Support\Str;

class CouponGenerator
{
    /**
     * Coupon code characters
     *
     * @var string
     */
    protected $characters;

    /**
     * Mask for code generation
     *
     * @var string
     */
    protected $mask;

    /**
     * Prefix for code generation
     *
     * @var string
     */
    protected $prefix;

    /**
     * Sufix for code generation
     *
     * @var string
     */
    protected $suffix;

    /**
     * Separator for code generation
     *
     * @var string
     */
    protected $separator = '-';

    /**
     * Prefix for code generation
     *
     * @var array
     */
    protected $generatedCodes = [];

    public function __construct(string $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ234567890', string $mask = '****')
    {
        $this->characters = $characters;
        $this->mask = $mask;
    }

    /**
     * Set code prefix
     *
     * @param string|null $prefix
     *
     * @return self
     */
    public function setPrefix(?string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * Set code prefix
     *
     * @param string|null $prefix
     *
     * @return self
     */
    public function setSuffix(?string $suffix): self
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * Set code separator
     *
     * @param string $separator
     *
     * @return void
     */
    public function setSeparator(string $separator): void
    {
        $this->separator = $separator;
    }

    /**
     * Generate unique coupon code
     *
     * @return string
     */
    public function generateUnique(): string
    {
        $code = $this->generate();

        while (in_array($code, $this->generatedCodes) === true) {
            $code = $this->generate();
        }

        $this->generatedCodes[] = $code;
        return $code;
    }

    /**
     * Generate coupon code
     *
     * @return string
     */
    public function generate(): string
    {
        $length = substr_count($this->mask, '*');

        $code = $this->getPrefix();
        $mask = $this->mask;
        $characters = collect(str_split($this->characters));

        for ($i = 0; $i < $length; $i++) {
            $mask = Str::replaceFirst('*', $characters->random(1)->first(), $mask);
        }

        $code .= $mask;
        $code .= $this->getSuffix();

        return $code;
    }

    /**
     * Get code prefix
     *
     * @return string
     */
    protected function getPrefix(): string
    {
        return $this->prefix !== null ? $this->prefix . $this->separator : '';
    }

    /**
     * Get code suffix
     *
     * @return string
     */
    protected function getSuffix(): string
    {
        return $this->suffix !== null ? $this->separator . $this->suffix : '';
    }
}
