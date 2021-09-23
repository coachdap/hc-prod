<?php

namespace Hp;

//  PROJECT HONEY POT ADDRESS DISTRIBUTION SCRIPT
//  For more information visit: http://www.projecthoneypot.org/
//  Copyright (C) 2004-2019, Unspam Technologies, Inc.
//
//  This program is free software; you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation; either version 2 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
//  02111-1307  USA
//
//  If you choose to modify or redistribute the software, you must
//  completely disconnect it from the Project Honey Pot Service, as
//  specified under the Terms of Service Use. These terms are available
//  here:
//
//  http://www.projecthoneypot.org/terms_of_service_use.php
//
//  The required modification to disconnect the software from the
//  Project Honey Pot Service is explained in the comments below. To find the
//  instructions, search for:  *** DISCONNECT INSTRUCTIONS ***
//
//  Generated On: Mon, 30 Sep 2019 13:03:40 -0400
//  For Domain: hoopscollege.com
//
//

//  *** DISCONNECT INSTRUCTIONS ***
//
//  You are free to modify or redistribute this software. However, if
//  you do so you must disconnect it from the Project Honey Pot Service.
//  To do this, you must delete the lines of code below located between the
//  *** START CUT HERE *** and *** FINISH CUT HERE *** comments. Under the
//  Terms of Service Use that you agreed to before downloading this software,
//  you may not recreate the deleted lines or modify this software to access
//  or otherwise connect to any Project Honey Pot server.
//
//  *** START CUT HERE ***

define('__REQUEST_HOST', 'hpr2.projecthoneypot.org');
define('__REQUEST_PORT', '80');
define('__REQUEST_SCRIPT', '/cgi/serve.php');

//  *** FINISH CUT HERE ***

interface Response
{
    public function getBody();
    public function getLines(): array;
}

class TextResponse implements Response
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getBody()
    {
        return $this->content;
    }

    public function getLines(): array
    {
        return explode("\n", $this->content);
    }
}

interface HttpClient
{
    public function request(string $method, string $url, array $headers = [], array $data = []): Response;
}

class ScriptClient implements HttpClient
{
    private $proxy;
    private $credentials;

    public function __construct(string $settings)
    {
        $this->readSettings($settings);
    }

    private function getAuthorityComponent(string $authority = null, string $tag = null)
    {
        if(is_null($authority)){
            return null;
        }
        if(!is_null($tag)){
            $authority .= ":$tag";
        }
        return $authority;
    }

    private function readSettings(string $file)
    {
        if(!is_file($file) || !is_readable($file)){
            return;
        }

        $stmts = file($file);

        $settings = array_reduce($stmts, function($c, $stmt){
            list($key, $val) = \array_pad(array_map('trim', explode(':', $stmt)), 2, null);
            $c[$key] = $val;
            return $c;
        }, []);

        $this->proxy       = $this->getAuthorityComponent($settings['proxy_host'], $settings['proxy_port']);
        $this->credentials = $this->getAuthorityComponent($settings['proxy_user'], $settings['proxy_pass']);
    }

    public function request(string $method, string $uri, array $headers = [], array $data = []): Response
    {
        $options = [
            'http' => [
                'method' => strtoupper($method),
                'header' => $headers + [$this->credentials ? 'Proxy-Authorization: Basic ' . base64_encode($this->credentials) : null],
                'proxy' => $this->proxy,
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $body = file_get_contents($uri, false, $context);

        if($body === false){
            trigger_error(
                "Unable to contact the Server. Are outbound connections disabled? " .
                "(If a proxy is required for outbound traffic, you may configure " .
                "the honey pot to use a proxy. For instructions, visit " .
                "http://www.projecthoneypot.org/settings_help.php)",
                E_USER_ERROR
            );
        }

        return new TextResponse($body);
    }
}

trait AliasingTrait
{
    private $aliases = [];

    public function searchAliases($search, array $aliases, array $collector = [], $parent = null): array
    {
        foreach($aliases as $alias => $value){
            if(is_array($value)){
                return $this->searchAliases($search, $value, $collector, $alias);
            }
            if($search === $value){
                $collector[] = $parent ?? $alias;
            }
        }

        return $collector;
    }

    public function getAliases($search): array
    {
        $aliases = $this->searchAliases($search, $this->aliases);
    
        return !empty($aliases) ? $aliases : [$search];
    }

    public function aliasMatch($alias, $key)
    {
        return $key === $alias;
    }

    public function setAlias($key, $alias)
    {
        $this->aliases[$alias] = $key;
    }

    public function setAliases(array $array)
    {
        array_walk($array, function($v, $k){
            $this->aliases[$k] = $v;
        });
    }
}

abstract class Data
{
    protected $key;
    protected $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function key()
    {
        return $this->key;
    }

    public function value()
    {
        return $this->value;
    }
}

class DataCollection
{
    use AliasingTrait;

    private $data;

    public function __construct(Data ...$data)
    {
        $this->data = $data;
    }

    public function set(Data ...$data)
    {
        array_map(function(Data $data){
            $index = $this->getIndexByKey($data->key());
            if(is_null($index)){
                $this->data[] = $data;
            } else {
                $this->data[$index] = $data;
            }
        }, $data);
    }

    public function getByKey($key)
    {
        $key = $this->getIndexByKey($key);
        return !is_null($key) ? $this->data[$key] : null;
    }

    public function getValueByKey($key)
    {
        $data = $this->getByKey($key);
        return !is_null($data) ? $data->value() : null;
    }

    private function getIndexByKey($key)
    {
        $result = [];
        array_walk($this->data, function(Data $data, $index) use ($key, &$result){
            if($data->key() == $key){
                $result[] = $index;
            }
        });

        return !empty($result) ? reset($result) : null;
    }
}

interface Transcriber
{
    public function transcribe(array $data): DataCollection;
    public function canTranscribe($value): bool;
}

class StringData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }
}

class CompressedData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }

    public function value()
    {
        $url_decoded = base64_decode(str_replace(['-','_'],['+','/'],$this->value));
        if(substr(bin2hex($url_decoded), 0, 6) === '1f8b08'){
            return gzdecode($url_decoded);
        } else {
            return $this->value;
        }
    }
}

class FlagData extends Data
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function value()
    {
        return $this->value ? ($this->data ?? null) : null;
    }
}

class CallbackData extends Data
{
    private $arguments = [];

    public function __construct($key, callable $value)
    {
        parent::__construct($key, $value);
    }

    public function setArgument($pos, $param)
    {
        $this->arguments[$pos] = $param;
    }

    public function value()
    {
        ksort($this->arguments);
        return \call_user_func_array($this->value, $this->arguments);
    }
}

class DataFactory
{
    private $data;
    private $callbacks;

    private function setData(array $data, string $class, DataCollection $dc = null)
    {
        $dc = $dc ?? new DataCollection;
        array_walk($data, function($value, $key) use($dc, $class){
            $dc->set(new $class($key, $value));
        });
        return $dc;
    }

    public function setStaticData(array $data)
    {
        $this->data = $this->setData($data, StringData::class, $this->data);
    }

    public function setCompressedData(array $data)
    {
        $this->data = $this->setData($data, CompressedData::class, $this->data);
    }

    public function setCallbackData(array $data)
    {
        $this->callbacks = $this->setData($data, CallbackData::class, $this->callbacks);
    }

    public function fromSourceKey($sourceKey, $key, $value)
    {
        $keys = $this->data->getAliases($key);
        $key = reset($keys);
        $data = $this->data->getValueByKey($key);

        switch($sourceKey){
            case 'directives':
                $flag = new FlagData($key, $value);
                if(!is_null($data)){
                    $flag->setData($data);
                }
                return $flag;
            case 'email':
            case 'emailmethod':
                $callback = $this->callbacks->getByKey($key);
                if(!is_null($callback)){
                    $pos = array_search($sourceKey, ['email', 'emailmethod']);
                    $callback->setArgument($pos, $value);
                    $this->callbacks->set($callback);
                    return $callback;
                }
            default:
                return new StringData($key, $value);
        }
    }
}

class DataTranscriber implements Transcriber
{
    private $template;
    private $data;
    private $factory;

    private $transcribingMode = false;

    public function __construct(DataCollection $data, DataFactory $factory)
    {
        $this->data = $data;
        $this->factory = $factory;
    }

    public function canTranscribe($value): bool
    {
        if($value == '<BEGIN>'){
            $this->transcribingMode = true;
            return false;
        }

        if($value == '<END>'){
            $this->transcribingMode = false;
        }

        return $this->transcribingMode;
    }

    public function transcribe(array $body): DataCollection
    {
        $data = $this->collectData($this->data, $body);

        return $data;
    }

    public function collectData(DataCollection $collector, array $array, $parents = []): DataCollection
    {
        foreach($array as $key => $value){
            if($this->canTranscribe($value)){
                $value = $this->parse($key, $value, $parents);
                $parents[] = $key;
                if(is_array($value)){
                    $this->collectData($collector, $value, $parents);
                } else {
                    $data = $this->factory->fromSourceKey($parents[1], $key, $value);
                    if(!is_null($data->value())){
                        $collector->set($data);
                    }
                }
                array_pop($parents);
            }
        }
        return $collector;
    }

    public function parse($key, $value, $parents = [])
    {
        if(is_string($value)){
            if(key($parents) !== NULL){
                $keys = $this->data->getAliases($key);
                if(count($keys) > 1 || $keys[0] !== $key){
                    return \array_fill_keys($keys, $value);
                }
            }

            end($parents);
            if(key($parents) === NULL && false !== strpos($value, '=')){
                list($key, $value) = explode('=', $value, 2);
                return [$key => urldecode($value)];
            }

            if($key === 'directives'){
                return explode(',', $value);
            }

        }

        return $value;
    }
}

interface Template
{
    public function render(DataCollection $data): string;
}

class ArrayTemplate implements Template
{
    public $template;

    public function __construct(array $template = [])
    {
        $this->template = $template;
    }

    public function render(DataCollection $data): string
    {
        $output = array_reduce($this->template, function($output, $key) use($data){
            $output[] = $data->getValueByKey($key) ?? null;
            return $output;
        }, []);
        ksort($output);
        return implode("\n", array_filter($output));
    }
}

class Script
{
    private $client;
    private $transcriber;
    private $template;
    private $templateData;
    private $factory;

    public function __construct(HttpClient $client, Transcriber $transcriber, Template $template, DataCollection $templateData, DataFactory $factory)
    {
        $this->client = $client;
        $this->transcriber = $transcriber;
        $this->template = $template;
        $this->templateData = $templateData;
        $this->factory = $factory;
    }

    public static function run(string $host, int $port, string $script, string $settings = '')
    {
        $client = new ScriptClient($settings);

        $templateData = new DataCollection;
        $templateData->setAliases([
            'doctype'   => 0,
            'head1'     => 1,
            'robots'    => 8,
            'nocollect' => 9,
            'head2'     => 1,
            'top'       => 2,
            'legal'     => 3,
            'style'     => 5,
            'vanity'    => 6,
            'bottom'    => 7,
            'emailCallback' => ['email','emailmethod'],
        ]);

        $factory = new DataFactory;
        $factory->setStaticData([
            'doctype' => '<!DOCTYPE html>',
            'head1'   => '<html><head>',
            'head2'   => '<title>Sematic</title></head>',
            'top'     => '<body><div align="center">',
            'bottom'  => '</div></body></html>',
        ]);
        $factory->setCompressedData([
            'robots'    => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VSrKT8ovKVZSSM7PK0nNK7FVystPLErOyCxL1cnLz8xLSa1QsrPBpz4tPycnv1zJDgDzslacVQAAAA',
            'nocollect' => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VcrL103NTczM0U3Oz8lJTS7JzM9TUkjOzytJzSuxVdJXsgMAKsBXli0AAAA',
            'legal'     => 'H4sIAAAAAAAAA61abXPTSBL-fr9iKrniQlUwDhAIpWyqTGLAW-DkLAPFx7E0tudW1vhmxslmf_31dLekkaMI2LqtYpFHbz3d_Tz9dItzLxeFEpkqCreVmS5Xvx0MD8TC2FxZPAyntjLP-dTFP869Df_LL86XpvRiKTP120FmdlYre3DxpFy4bSLaf50v-OLMFMb-dvge_7vIzp-H1Yvz5wu-73xh46PDs1fJWok7tXDht39yeHJykoh7sxO4YPxaWRFWXycqLHxTi_DrNNFeCXrEycmrRD05fPsmyQVcHhblSpV0kxMGH7yGn8OTZDMQ83VYKE04P0yeHL46TbyV5f7D4cRrtLGxWDyy9XhH6VZl4VWnCVoUDs_omintrXz2cbeRYcFtda7IfHccFrb0w6ys3ODu5Y42YTaSDujJlVXjjdSFCKeGQ1yceKGdsOSCgneoBuC_s7d4wVo6IcUtvd4bC37CN9_KYqeEWVbrOnhv-JIMlyur1EaVbWc8EvHlg4j3Z8j2wfV7Dh3LbC220qIlZJUkN5QUK483HB38viNH6ExTxBV4YtV4zO3gQYW8wweVudhSRljcdPDV8EUilgpQQVfcC5l5fFTKUbqlh2VqUL0AY7wwt9158siW9eMusp03-OoGOP8dkJGZEtNjI8HGLe8DjV7sHIR7Ho6_aqcZTtZV9n2dpJP59SwNxzej2fy7uJ4xDl9Ccp2dJu_S8b-_jPH6ykoggl9kg3g_8AftABPFkhN8E1YhXG_PMKMB2pkXvkEzZH9PqqxoV7eKb3hxktDKjuKRZXhmIzJp6cXLXVhYBnYQGvNYQXDh4reJcugct1Q28GRlchTMR6K4rvzTce6PHhCkYbF-BZGX83Sg0SSCenV6mAT4vk6acDa2LWjBu2MRMUMPKnPl9KpsEiaLSKogVw4q2_LKOKcIaBjPzKxK_ZfKETSVw8MD3iQlMm2x42CXxkdQBsQ9N7bLNhNld18NgeA5frSsasXwFVOiE8DduCoCttWfnYjsj6jrpiJ86j3tNDBhg330PRccJvpRRtHThqhUWZWLER4LCcTc8VrFr5Vb9KndKOIxQYwrC9wRVcNSLKzZrZqNfUeSfxNyhDMHKgwnONL2T5G2fLjzflepzrqO74VrvREUG7TfCofsClhD7gXXTXK4LMoNsLRKmra9ow-Q-y-S8Zg4rcuUnE1Jx9OryfQDV1qQFeLdbDy6_P8yGf28W2soJfcYEdYmsKklhtwSZkFLAcNgUQd_sPhwmCpFcT_o2siKzRyV-ORc3-qcgiuLH2HD6tW60juRnRrfHJjRx8QGQb0ZX05Gn-LwXXyKiUlDiRGQbrglNxBTUz5D2ZSrP5UlucJpCtGWWRY_35T9ONaxkX4tg4fCwh2BSOUrRRAvgHzgnCR_OG_1gjyCC7kN3ET0DYLtX06gf7dM-s4V970w_0ltR-DlMIOtaE0nk1UR1CWcoDxAnx087Stnbk3xJXdudKlZ16AO2RaatgPalpSstqq4R3tI03kJShiyGLEF5q0klTjHUERUVmI3bGLwKzuXtyGV7w0h16oqKTQJJkAOSM5KQcHDwxt3td74OJqLj6PZ1wjR0-_i8xj1Bl4grt-L-cdfFhwNPc2fHL5-m8w-t-pqxYqQmJQgRWHuwkbI0Vj3uahVLUeUkcoSXzmKNa1OOaJBvofVI_dU3K3JvSDYYwdXAYuTXEFN2u6BcHI5nqbjPqwg-7UFA1QhcRvEgKHfb14k0E-U4qtuXmfNwngCKUDkGHSwjF8d0EL1jFoF5cA62rLUhPJ2uSvFl1T88xRaojNKOaAH6BZwgwMxKT3T-Qbvgp6EurGc4GjWeqFrAqr5ZnRz82lyOdqXQ8OkE7UVzbudJifj7kqVxY0R52YhFkpUKhGT2OtbJS5Nu-SoTSOEgCkBtURDpHu8E3f8qjXVcrHWG6ErOAWiyryNSm4U2dn4EiIDaXmVPiyRu9DQvnmZ0G499RvIilsZlfZdqf_LWqrmB8hTvLAO5zjFWgeF7xi3no4-jI_Sp3Q8FnhyjFn0Of1VjIUYTa9aNeLyehrHy6kc7QnH0JTkFAWvTeVGLIzfuLkvuWBU3JijLzF1HeUHPMNbQ86leYAJo4A-hCDtWVaoEDIW0nvxGKfz2eRyPomNt1AwCu7omkQIwLKOwtzH8RlB_m1SUPzyY7hws229mNwWujVo9DEx-57IfXyoanvVkdCLAwkR-j9qZ4IehjqZU7kml4JYzEiGYGnkbM0HkSvefRq3yz7w52ny7WGaMlCyAPbe2U6o3IAfYSzVGpZAkBsLVDKll4xSceRpwQFCfVPClBjV1Y-qS-cb86YTIE0d6mzJ7QwqEJ0Jp-ztfviv37e2jF1wnAql8uKGe9Om-1JgLrzpIBzfi430GWl9Eh5iWd39YTT_iEUIcTaZhrX5dahqYtI4EupcOqZK-HMgBEOvJoTu6ykVzMdiRAMa3IkbCB6qOeI1NRDvqLOrx2WhPQF5d9RsNaR8VQgxRMd9EZc7vzaWCgWPRmoZjJkJ9UBsCRdxFID1zpIWIYb6NUyuZw93VkJuB2WJxxlRwi5XnXatokwkIjgWa2lvG1QXKmQnT49is6A968s0KF5bIjpWC9DDURu8FipM3_AZOKPk2RQmSK1AFSndgusFKg_EU3gmlOXQTe95aZ9yf_8ya9EW7GMbODJoGORPC-zJ47reWUSdLhwqrieFbHAYsn2Ub4g1IIZIDfw7DTqzs3GpxlPfce-bbuxWMYLH1Arijlk_TB5hU_vpMuubZHxJEXItVz3QEsAKBtpnEiLYdFayFU0VXF7Iq2HiR8lcA_tYpPPrGYL4ajydT95PUKiCbhv8Eo73-AcHbWz_D6ZHNRy8ODrgWQMAQ9kNZRaPJKFqaWLdVRVHZAG4jn-HIqwp7Xgo2DfUMr5p4MnsOb4Sa8tGO6cr3fOjgU4Tz-n19NnHL58xp-KtgUSvqjfpr8XO1zgLExQQsK0ZvqVhh2khB3ztpb3HmwAf0DvTjKpvl5AYjFQ2oNYSJLRkPZI8TWha6bwkpUsEw4Yj0f4F9U52zi19tz_SK1SBl3P8qy2sVF6FUywQF0trNtXHDQqIoXEmlUEE50F0jOs8KiZOrj4DwCKmhMANQWeQodNNEwWr9iPXZqTRuy_puKWkolszkgAHT4VeRt9nQpPA0St5FY6lM2WtTYKEnc9GWD5nApQmSVv0Tm3MTyIuro7f6F0Lx2qeWbNzFqebDj5q_Y50SR1NSYWUYAQBSHlL5GAROnlienLCnXY4JhwSuy4Fj9nxnmDMWaLRX2bZh6MQZrMfkoeC5rqVQAR4klvGi0ITi1veSGePpWv004Yg1XtUAKRkbBQREbSCRUFJQNYtgVnX1I1vmlWmF1VNbZsuOaOPA1oWxb2gDoElS7k6jiu4hC7YFLLRMO2o1-WS3r1ae1ajfePMiOQcooi-iIHyDh8vYCdEUCD_dDXBpBlLRJeAOEJDGL9gKDBV6M4VfZEYcr_KA4luy5mmc54mDEjy3kGa7egFW6oG7IGeCdONNdGng-pPitqLpicznpzOsTTRSCWl8j_9e9gLBNDJhrIebZycvEiagps33WMZTU42sixZY2IYsOjpTB08HURXLULilA0bY5L_AZ7fOS6Zkp6Bv-5K1Vn9dGTaSbJsxYbK9ouko5_vZBIZdXWwz21Bpcl36816Nkqvpl4-qMrQU2LN_VE_9K396QpzYgftYPVNGSFT0uQI81vj1BDJeKsrHNVlHct8qd06ro9UhGk6dsrji1U9CsbxS-W6vXlznN_4HXaLESJWTEPHFlEGR8ppTv1yn9CcAGwp28h7Jf4D6eew4Ac0gj9uCXpKzFkDUSPrRJdhpVD16Aox7MXWePr-ggqSW_O2PHyMTaoBM_SAIzHHCV2zudHl5fhmPvp7oDIs91jb4HcWYvNHTNFNhlCYzoZJoSQTVBO5PHynaow0dW8bt3X7f2gCeUcMvqvKe_gRAtW6BZpBf4-V3tDHaF99w3dMsLHWbOkc_nAY8KBdlxnwZELhglsJBjxenAtdkp16b1JYc-cw2VVfhYGpqT_AHfGUKtrXg4SmMaflj8g1hmC1oPxzg_j6yewq_DW9HIvQ5nXmwHP8xzfP8V_twAGc_x8oZktzwiMAAA',
            'style'     => 'H4sIAAAAAAAAAyXMOw6AIAwA0KuQuIqfFYgj96hQEiK2BjpgjHd38B3guSZ3wQ2mI5_wBC5czeC9t4lJzM4lqnW5uoKaoYwNqOmGNScr2EVHDFxBMpMhJrSvm__vAwyyM2pXAAAA',
            'vanity'    => 'H4sIAAAAAAAAA22SwW7iMBCGX2VkrgthS4uESaLVIqqqUgui3cMendgkXozHGk9Jefs6KT1sW1kjzVie7__Hds6qcgZq41wMqra-KcRU9GVQWl_KCkkb6rPIZ2cKUan60BC-eC1Hi8Vi2VnNrbyaTcPrUpQ5UwoNJ-Vs4wvBGD4aL1AJP8MrXKW4SXGdut4lxmSblmVEZ_VwZLRarXpi8ubhwtijZ1mh09DrgSKr3I-ofBxHQ3a_rNEhydF8Pl8mZdl7ChgtW_SSjFNsTyYxf-VZTy3zjPUXu3DJndmzgE_mZ0l1mtb1-7QKWjL7QrTMQWZZ13WTQPjP1NyiN-eAPEFqMgG1UzEW4mCPSpQP64ff6x1sbmG729yvV89wt3lc_4Xt5jnPVJlX9C35xSfTx0mNR_Ef7intwp2ik4lsCLaEnAykkeHRcId06IHJ1slqo6E6w58BNEgNF5D1j5YNv6F8A1c5cLQVAgAA',
        ]);
        $factory->setCallbackData([
            'emailCallback' => function($email, $style = null){
                $value = $email;
                $display = 'style="display:' . ['none',' none'][random_int(0,1)] . '"';
                $style = $style ?? random_int(0,5);
                $props[] = "href=\"mailto:$email\"";
        
                $wrap = function($value, $style) use($display){
                    switch($style){
                        case 2: return "<!-- $value -->";
                        case 4: return "<span $display>$value</span>";
                        case 5:
                            $id = 'tr8te';
                            return "<div id=\"$id\">$value</div>\n<script>document.getElementById('$id').innerHTML = '';</script>";
                        default: return $value;
                    }
                };
        
                switch($style){
                    case 0: $value = ''; break;
                    case 3: $value = $wrap($email, 2); break;
                    case 1: $props[] = $display; break;
                }
        
                $props = implode(' ', $props);
                $link = "<a $props>$value</a>";
        
                return $wrap($link, $style);
            }
        ]);

        $transcriber = new DataTranscriber($templateData, $factory);

        $template = new ArrayTemplate([
            'doctype',
            'injDocType',
            'head1',
            'injHead1HTMLMsg',
            'robots',
            'injRobotHTMLMsg',
            'nocollect',
            'injNoCollectHTMLMsg',
            'head2',
            'injHead2HTMLMsg',
            'top',
            'injTopHTMLMsg',
            'actMsg',
            'errMsg',
            'customMsg',
            'legal',
            'injLegalHTMLMsg',
            'altLegalMsg',
            'emailCallback',
            'injEmailHTMLMsg',
            'style',
            'injStyleHTMLMsg',
            'vanity',
            'injVanityHTMLMsg',
            'altVanityMsg',
            'bottom',
            'injBottomHTMLMsg',
        ]);

        $hp = new Script($client, $transcriber, $template, $templateData, $factory);
        $hp->handle($host, $port, $script);
    }

    public function handle($host, $port, $script)
    {
        $data = [
            'tag1' => '8f1054decb2cc3851083461ea1bfc691',
            'tag2' => '020a569d6250bfc4beb115f92f93ec01',
            'tag3' => '3649d4e9bcfd3422fb4f9d22ae0a2a91',
            'tag4' => md5_file(__FILE__),
            'version' => "php-".phpversion(),
            'ip'      => $_SERVER['REMOTE_ADDR'],
            'svrn'    => $_SERVER['SERVER_NAME'],
            'svp'     => $_SERVER['SERVER_PORT'],
            'sn'      => $_SERVER['SCRIPT_NAME']     ?? '',
            'svip'    => $_SERVER['SERVER_ADDR']     ?? '',
            'rquri'   => $_SERVER['REQUEST_URI']     ?? '',
            'phpself' => $_SERVER['PHP_SELF']        ?? '',
            'ref'     => $_SERVER['HTTP_REFERER']    ?? '',
            'uagnt'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ];

        $headers = [
            "User-Agent: PHPot {$data['tag2']}",
            "Content-Type: application/x-www-form-urlencoded",
            "Cache-Control: no-store, no-cache",
            "Accept: */*",
            "Pragma: no-cache",
        ];

        $subResponse = $this->client->request("POST", "http://$host:$port/$script", $headers, $data);
        $data = $this->transcriber->transcribe($subResponse->getLines());
        $response = new TextResponse($this->template->render($data));

        $this->serve($response);
    }

    public function serve(Response $response)
    {
        header("Cache-Control: no-store, no-cache");
        header("Pragma: no-cache");

        print $response->getBody();
    }
}

Script::run(__REQUEST_HOST, __REQUEST_PORT, __REQUEST_SCRIPT, __DIR__ . '/phpot_settings.php');

