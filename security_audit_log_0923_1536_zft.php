<?php
// 代码生成时间: 2025-09-23 15:36:55
class SecurityAuditLog {

    /**
     * Logs a security event to a file.
     *
     * @param string $message The message to be logged.
     * @param string $severity The severity level of the event.
     * @return bool Returns true on success, false on failure.
     */
    public function logEvent($message, $severity = 'INFO') {
        try {
            // Define the log file path
            $logFile = APPPATH . 'logs/security_audit.log';

            // Check if the log file is writable
            if (!is_writable($logFile)) {
                // Log a warning if the file is not writable
                error_log('Security audit log file is not writable.');
                return false;
            }

            // Get the current timestamp
            $timestamp = date('Y-m-d H:i:s');

            // Create the log entry
            $logEntry = '[' . $timestamp . '] [' . $severity . '] ' . $message . "
";

            // Write the log entry to the file
            return file_put_contents($logFile, $logEntry, FILE_APPEND) !== false;
        } catch (Exception $e) {
            // Handle any exceptions that occur during logging
            error_log('Error logging security event: ' . $e->getMessage());
            return false;
        }
    }
}

// Example usage:
// $auditLogger = new SecurityAuditLog();
// $auditLogger->logEvent('User login attempt.', 'WARNING');
