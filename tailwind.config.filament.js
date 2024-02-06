import preset from './vendor/filament/filament/tailwind.config.preset'
import common from './tailwind.common.js'

module.exports = {
    presets: [preset],
    extend: {

    },
    plugins: [require("daisyui")],
    daisyui: {
        darkTheme: "dark",
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["[data-theme=light]"],
                    "primary": common.colors.primary["500"],
                    "secondary": common.colors.primary["400"],
                    "primary-content": '#ffffff',
                    "neutral": '#c4c4c4',
                    "base-100": "#ffffff",
                }
            },
            {
                dark: {
                    ...require("daisyui/src/theming/themes")["[data-theme=dark]"],
                    primary: common.colors.primary["500"],
                    secondary: common.colors.primary["400"],
                }
            }
        ],
    },
}
