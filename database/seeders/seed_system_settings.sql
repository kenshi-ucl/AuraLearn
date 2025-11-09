-- Seed system settings
INSERT INTO system_settings (key, value, type, "group", label, description, is_editable, is_sensitive, created_at, updated_at)
VALUES
  ('app_name', 'AuraLearn', 'string', 'general', 'Application Name', 'The name of your application', true, false, NOW(), NOW()),
  ('app_url', 'http://localhost:8000', 'string', 'general', 'Application URL', 'The URL where your application is hosted', true, false, NOW(), NOW()),
  ('app_env', 'production', 'string', 'general', 'Environment', 'Application environment', false, false, NOW(), NOW()),
  ('app_debug', '0', 'boolean', 'general', 'Debug Mode', 'Enable debug mode for development', true, false, NOW(), NOW())
ON CONFLICT (key) DO UPDATE SET
  value = EXCLUDED.value,
  updated_at = NOW();

