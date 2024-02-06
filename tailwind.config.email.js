import common from './tailwind.common.js'

export default {
    content: [
        './resources/views/emails/**/*.blade.php',
        './resources/views/components/layouts/email.blade.php',
        "./resources/**/*.js",
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: common.colors.primary,
                secondary: common.colors.secondary,
            },
        },
    }
}
