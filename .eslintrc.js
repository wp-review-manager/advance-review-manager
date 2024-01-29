// .eslintrc.js or .eslintrc.json
module.exports = {
    root: true,
    env: {
        node: true,
        es6: true,
    },
    extends: [
        'plugin:vue/vue3-recommended',
        'eslint:recommended',
    ],
    parserOptions: {
        // parser: 'babel-eslint',
    },
    rules: {
      // Additional rules
      'vue/no-unused-components': 'warn', // Warn about unused components
      'vue/no-unused-vars': 'warn', // Warn about unused variables in templates
      'vue/require-default-prop': 'warn', // Warn if a prop's default value is not defined
      'vue/require-prop-types': 'warn', // Warn if prop types are not defined
      'vue/no-mutating-props': 'error', // Disallow mutating prop directly
      'vue/valid-v-slot': ['error', { allowModifiers: true }], // Enforce valid usage of v-slot
      'vue/no-v-html': 'off', // Allowing the use of v-html
      'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'warn', // Error for console.log in production
      'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'warn', // Error for debugger in production
      'no-unused-vars': 'warn', // Warn about unused variables
      'prefer-const': 'warn', // Prefer const over let when variable value doesn't change
      'semi': ['error', 'always'], // Require semicolons at the end of statements,
      'vue/multi-word-component-names': 'off'
    },
};  