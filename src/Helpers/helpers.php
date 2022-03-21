<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Codictive\Cms\Models\Tag;
use Codictive\Cms\Models\User;
use Illuminate\Http\UploadedFile;
use Codictive\Cms\Models\KeyValue;
use Codictive\Cms\Models\SystemLog;
use Codictive\Cms\Models\AuthSession;

require_once 'thumbnail.php';

function kv(string $key, mixed $val = null): mixed
{
    return count(func_get_args()) == 1 ? KeyValue::get($key) : KeyValue::set($key, $val);
}

function appName(): string
{
    return kv('app.name');
}

function unlinkIfExists(string $fp)
{
    file_exists($fp) && unlink($fp);
}

function startsWith(string $haystack, string $needle): bool
{
    return Str::startsWith($haystack, $needle);
}

function title(string $title): string
{
    return sprintf('%s | %s', $title, appName());
}

function moveFile(UploadedFile $file, string $dst): string
{
    if (! $file || ! $file->isValid()) {
        SystemLog::warning('Helpers.moveFile', 'file is null or not valid. dst: %s', $dst);

        return '';
    }

    $ext = $file->extension();

    $fn = Uuid::uuid4()->getHex()->toString();
    $ext && $fn .= ".{$ext}";
    $file->move($dst, $fn);

    return $fn;
}

function currentUser(): User | null
{
    try {
        $token = request()->session()->get('auth_token');
        if (! $token) {
            return null;
        }

        $session = AuthSession::byToken($token, ['user', 'user.roles', 'user.roles.permissions']);
        if (! $session) {
            return null;
        }

        return $session->user;
    } catch (Exception $exception) {
        SystemLog::error('Helpers.currentUser', 'Exception thrown when accessing request session %d %s (%s:%d) %s', $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine(), request()->getUri());

        return null;
    }
}

function getCachePath(string $key): string
{
    $parts = array_slice(str_split($hash = sha1($key), 2), 0, 2);

    return config('cache.stores.file.path') . '/' . implode('/', $parts) . '/' . $hash;
}

function getCacheAge(string $key): int
{
    $path = getCachePath($key);

    return file_exists($path) ? filemtime($path) : 0;
}

function hasFilters(): bool
{
    return count(request()->except('page')) > 0;
}

function validateRecaptcha(string $code): bool
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['secret' => kv('keys.recaptcha.secret_key'), 'response' => $code]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    return $response && $response['success'];
}

/**
 * Searches for tag with given name, returns it or creates new one if non found.
 *
 * @param string $name
 * @param string $slug
 */
function findOrCreateTag($name, $slug = null): Tag
{
    $tag = Tag::where('name', $name)->first();
    if (null == $tag) {
        $tag = Tag::create(['name' => $name, 'slug' => $slug ?: slugify($name)]);
    }

    return $tag;
}
