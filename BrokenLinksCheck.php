/*check the HTTP status code of a web resource (e.g., a URL) to determine if it returns a 404 Not Found status code or some other status code. */
 /* cURL Approach */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $path);
curl_setopt($ch, CURLOPT_NOBODY, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_exec($ch);
$is404 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);


 /* get_headers() and preg_match() Approach  */
$headers = @get_headers($path);
$headers = (is_array($headers)) ? implode("\n ", $headers) : $headers;
$response_header_not_found = (bool)preg_match('#^HTTP/.*\s+[(404)]+\s#i', $headers);
$response_Forbidden = (bool)preg_match('#^HTTP/.*\s+[(403)]+\s#i', $headers);
$response_found = (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);


