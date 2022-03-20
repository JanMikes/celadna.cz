module.exports = ({ env }) => ({
  connection: {
    client: 'postgres',
    connection: {
      host: env('DATABASE_HOST', 'postgres'),
      port: env.int('DATABASE_PORT', 5432),
      database: env('DATABASE_NAME', 'celadna'),
      user: env('DATABASE_USERNAME', 'celadna'),
      password: env('DATABASE_PASSWORD', 'celadna'),
      ssl: env.bool('DATABASE_SSL', false),
    },
  },
});
