<?php

function get_plugin_info($plugin_name) {
	$url = "https://plugins.matomo.org/api/1.0/plugins/{$plugin_name}/info";

	// Initialize a cURL session
	$ch = curl_init();

	// Set the URL
	curl_setopt($ch, CURLOPT_URL, $url);

	// Return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Execute the cURL session
	$response = curl_exec($ch);

	// Check for errors
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
		return null;
	}

	// Close the cURL session
	curl_close($ch);

	// Decode the JSON response
	$plugin_info = json_decode($response, true);

	// Return the plugin information
	return $plugin_info;
}

function print_latest_plugin_version($plugin_name) {
	$plugin_info = get_plugin_info($plugin_name);

	if ($plugin_info) {
		// Check if the latestVersion key exists and print it
		if (isset($plugin_info['latestVersion'])) {
			$latest_version = $plugin_info['latestVersion'];
			echo "The latest version of the plugin '{$plugin_name}' is {$latest_version}\n";
		} else {
			echo "No latest version information found for the plugin '{$plugin_name}'\n";
		}
	} else {
		echo "Could not get plugin information for '{$plugin_name}'\n";
	}
}

// Example usage
$plugin_name = "QueuedTracking";  // Replace with actual plugin name
print_latest_plugin_version($plugin_name);
