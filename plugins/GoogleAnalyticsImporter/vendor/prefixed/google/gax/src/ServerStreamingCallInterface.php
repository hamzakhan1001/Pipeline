<?php

/*
 * Copyright 2021 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\ApiCore;

/**
 * @internal
 */
interface ServerStreamingCallInterface
{
    /**
     * Start the call.
     *
     * @param mixed $data     The data to send
     * @param array<mixed> $metadata Metadata to send with the call, if applicable
     *                        (optional)
     * @param array<mixed> $options  An array of options, possible keys:
     *                        'flags' => a number (optional)
     * @return void
     */
    public function start($data, array $metadata = [], array $options = []);
    /**
     * @return mixed An iterator of response values.
     */
    public function responses();
    /**
     * Return the status of the server stream.
     *
     * @return \stdClass The API status.
     */
    public function getStatus();
    /**
     * @return mixed The metadata sent by the server.
     */
    public function getMetadata();
    /**
     * @return mixed The trailing metadata sent by the server.
     */
    public function getTrailingMetadata();
    /**
     * @return string The URI of the endpoint.
     */
    public function getPeer();
    /**
     * Cancels the call.
     *
     * @return void
     */
    public function cancel();
    /**
     * Set the CallCredentials for the underlying Call.
     *
     * @param mixed $call_credentials The CallCredentials object
     *
     * @return void
     */
    public function setCallCredentials($call_credentials);
}
