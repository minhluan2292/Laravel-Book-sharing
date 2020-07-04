<?php

namespace App\Providers;

class ResponseHelper
{
    public static $UNPROCESSABLE_ENTITY = 422;
    public static $NOT_FOUND = 404;
    public static $NO_CONTENT = 204;
    public static $OK = 200;

    public static function errorResponse($message, $code)
    {
        return response()->json([
            'error' => [
                'message' => $message
            ]
            ], $code);
    }

    public static function successResponse($message, $code)
    {
        return response()->json([
            'success' => [
                'message' => $message
            ]
            ], $code);
    }

    public static function successOKResponse($message)
    {
        return self::successResponse($message, self::$OK);
    }

    public static function missingEntityResponse($message)
    {
        return self::errorResponse($message, self::$UNPROCESSABLE_ENTITY);
    }

    public static function unknownResourceResponse()
    {
        return self::errorResponse('Unknown resource', self::$NOT_FOUND);
    }

    public static function noContentResponse()
    {
        return self::errorResponse('No Content', self::$NO_CONTENT);
    }

    public static function emailExistResponse()
    {
        return self::errorResponse('Email Exist', self::$NOT_FOUND);
    }

}