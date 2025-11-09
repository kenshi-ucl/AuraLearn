<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\DB;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'app_name',
                'value' => env('APP_NAME', 'Laravel'),
                'type' => 'string',
                'group' => 'general',
                'label' => 'Application Name',
                'description' => 'The name of your application',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'app_url',
                'value' => env('APP_URL', 'http://localhost:8000'),
                'type' => 'string',
                'group' => 'general',
                'label' => 'Application URL',
                'description' => 'The URL where your application is hosted',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'app_env',
                'value' => env('APP_ENV', 'production'),
                'type' => 'string',
                'group' => 'general',
                'label' => 'Environment',
                'description' => 'Application environment (local, staging, production)',
                'is_editable' => 0,
                'is_sensitive' => 0
            ],
            [
                'key' => 'app_debug',
                'value' => env('APP_DEBUG', false) ? '1' : '0',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Debug Mode',
                'description' => 'Enable debug mode for development',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],

            // Database Settings
            [
                'key' => 'db_connection',
                'value' => env('DB_CONNECTION', 'pgsql'),
                'type' => 'string',
                'group' => 'database',
                'label' => 'Database Connection',
                'description' => 'Database driver type',
                'is_editable' => 0,
                'is_sensitive' => 0
            ],
            [
                'key' => 'db_host',
                'value' => env('DB_HOST', 'localhost'),
                'type' => 'string',
                'group' => 'database',
                'label' => 'Database Host',
                'description' => 'Database server hostname',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'db_port',
                'value' => env('DB_PORT', '5432'),
                'type' => 'number',
                'group' => 'database',
                'label' => 'Database Port',
                'description' => 'Database server port',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'db_database',
                'value' => env('DB_DATABASE', 'postgres'),
                'type' => 'string',
                'group' => 'database',
                'label' => 'Database Name',
                'description' => 'Name of the database',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],

            // AI Settings
            [
                'key' => 'nebius_api_key',
                'value' => env('NEBIUS_API_KEY', ''),
                'type' => 'string',
                'group' => 'ai',
                'label' => 'Nebius API Key',
                'description' => 'API key for Nebius AI service',
                'is_editable' => 1,
                'is_sensitive' => 1
            ],
            [
                'key' => 'nebius_base_url',
                'value' => env('NEBIUS_BASE_URL', 'https://api.studio.nebius.com/v1/'),
                'type' => 'string',
                'group' => 'ai',
                'label' => 'Nebius Base URL',
                'description' => 'Base URL for Nebius API',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'nebius_model',
                'value' => env('NEBIUS_MODEL', 'openai/gpt-oss-20b'),
                'type' => 'string',
                'group' => 'ai',
                'label' => 'Nebius Model',
                'description' => 'AI model to use for chat completions',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'embedding_model',
                'value' => env('EMBEDDING_MODEL', 'BAAI/bge-multilingual-gemma2'),
                'type' => 'string',
                'group' => 'ai',
                'label' => 'Embedding Model',
                'description' => 'Model for generating embeddings',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'aurabot_max_tokens',
                'value' => env('AURABOT_MAX_TOKENS', '10000'),
                'type' => 'number',
                'group' => 'ai',
                'label' => 'AuraBot Max Tokens',
                'description' => 'Maximum tokens for AuraBot responses',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'aurabot_attempt_limit',
                'value' => env('AURABOT_ATTEMPT_LIMIT', '3'),
                'type' => 'number',
                'group' => 'ai',
                'label' => 'AuraBot Attempt Limit',
                'description' => 'Maximum questions per session (999 = unlimited)',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],

            // RAG Settings
            [
                'key' => 'vector_dim',
                'value' => env('VECTOR_DIM', '1024'),
                'type' => 'number',
                'group' => 'rag',
                'label' => 'Vector Dimensions',
                'description' => 'Dimensions for vector embeddings',
                'is_editable' => 0,
                'is_sensitive' => 0
            ],
            [
                'key' => 'rag_max_chunks',
                'value' => env('RAG_MAX_CHUNKS', '5'),
                'type' => 'number',
                'group' => 'rag',
                'label' => 'Max RAG Chunks',
                'description' => 'Maximum chunks to retrieve for RAG',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'rag_chunk_size',
                'value' => env('RAG_CHUNK_SIZE', '1000'),
                'type' => 'number',
                'group' => 'rag',
                'label' => 'RAG Chunk Size',
                'description' => 'Size of text chunks for RAG',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'rag_chunk_overlap',
                'value' => env('RAG_CHUNK_OVERLAP', '200'),
                'type' => 'number',
                'group' => 'rag',
                'label' => 'RAG Chunk Overlap',
                'description' => 'Overlap between text chunks',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],

            // Cache & Performance
            [
                'key' => 'cache_store',
                'value' => env('CACHE_STORE', 'file'),
                'type' => 'string',
                'group' => 'performance',
                'label' => 'Cache Driver',
                'description' => 'Cache storage driver',
                'is_editable' => 0,
                'is_sensitive' => 0
            ],
            [
                'key' => 'queue_connection',
                'value' => env('QUEUE_CONNECTION', 'database'),
                'type' => 'string',
                'group' => 'performance',
                'label' => 'Queue Connection',
                'description' => 'Queue driver for background jobs',
                'is_editable' => 0,
                'is_sensitive' => 0
            ],
            [
                'key' => 'session_driver',
                'value' => env('SESSION_DRIVER', 'file'),
                'type' => 'string',
                'group' => 'performance',
                'label' => 'Session Driver',
                'description' => 'Session storage driver',
                'is_editable' => 0,
                'is_sensitive' => 0
            ],

            // Mail Settings
            [
                'key' => 'mail_mailer',
                'value' => env('MAIL_MAILER', 'log'),
                'type' => 'string',
                'group' => 'mail',
                'label' => 'Mail Driver',
                'description' => 'Mail driver for sending emails',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'mail_host',
                'value' => env('MAIL_HOST', '127.0.0.1'),
                'type' => 'string',
                'group' => 'mail',
                'label' => 'Mail Host',
                'description' => 'SMTP server hostname',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'mail_port',
                'value' => env('MAIL_PORT', '2525'),
                'type' => 'number',
                'group' => 'mail',
                'label' => 'Mail Port',
                'description' => 'SMTP server port',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'mail_from_address',
                'value' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'type' => 'string',
                'group' => 'mail',
                'label' => 'Mail From Address',
                'description' => 'Default sender email address',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],

            // Supabase Settings
            [
                'key' => 'supabase_url',
                'value' => env('SUPABASE_URL', ''),
                'type' => 'string',
                'group' => 'supabase',
                'label' => 'Supabase URL',
                'description' => 'Supabase project URL',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
            [
                'key' => 'supabase_anon_key',
                'value' => env('SUPABASE_ANON_KEY', ''),
                'type' => 'string',
                'group' => 'supabase',
                'label' => 'Supabase Anon Key',
                'description' => 'Supabase anonymous key',
                'is_editable' => 1,
                'is_sensitive' => 1
            ],

            // Filesystem
            [
                'key' => 'filesystem_disk',
                'value' => env('FILESYSTEM_DISK', 'local'),
                'type' => 'string',
                'group' => 'storage',
                'label' => 'Filesystem Driver',
                'description' => 'Default filesystem disk',
                'is_editable' => 1,
                'is_sensitive' => 0
            ],
        ];

        foreach ($settings as $setting) {
            // Convert integers to proper booleans for PostgreSQL
            $isEditable = $setting['is_editable'] === 1 || $setting['is_editable'] === true;
            $isSensitive = $setting['is_sensitive'] === 1 || $setting['is_sensitive'] === true;
            
            // Use raw SQL with parameter binding to ensure proper boolean handling
            DB::statement("
                INSERT INTO system_settings (key, value, type, \"group\", label, description, is_editable, is_sensitive, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?::boolean, ?::boolean, NOW(), NOW())
                ON CONFLICT (key) DO UPDATE SET
                    value = EXCLUDED.value,
                    type = EXCLUDED.type,
                    \"group\" = EXCLUDED.\"group\",
                    label = EXCLUDED.label,
                    description = EXCLUDED.description,
                    is_editable = EXCLUDED.is_editable,
                    is_sensitive = EXCLUDED.is_sensitive,
                    updated_at = NOW()
            ", [
                $setting['key'],
                $setting['value'],
                $setting['type'],
                $setting['group'],
                $setting['label'],
                $setting['description'],
                $isEditable,
                $isSensitive
            ]);
        }

        $this->command->info('System settings seeded successfully!');
    }
}

