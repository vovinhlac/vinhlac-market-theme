/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./*.php",
		"./inc/**/*.php",
		"./template-parts/**/*.php",
		"./woocommerce/**/*.php",
		"./assets/src/**/*.js",
		"../lacvo-core/**/*.php",
	],
	safelist: [
		"logged-in",
		"woocommerce",
		"woocommerce-page",
		"woocommerce-account",
		"woocommerce-MyAccount-navigation",
		"woocommerce-MyAccount-content",
		"woocommerce-products-header",
		"woocommerce-products-header__title",
		"woocommerce-result-count",
		"woocommerce-ordering",
		"woocommerce-info",
		"woocommerce-error",
		"woocommerce-message",
		"woocommerce-checkout",
		"woocommerce-product-details__short-description",
		"lacvo-customer-field",
		"cart-collaterals",
		"cart_totals",
		"page-numbers",
		"payment_box",
		"page-title",
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ['"Be Vietnam Pro"', "ui-sans-serif", "system-ui", "sans-serif"],
				mono: ["ui-monospace", "SFMono-Regular", "Menlo", "monospace"],
			},
			colors: {
				brand: {
					50: "#eef2fc",
					100: "#d1ddfa",
					200: "#adc3f5",
					500: "#1d51ed",
					600: "#1142d4",
					700: "#0d36ae",
					950: "#11162c",
				},
			},
		},
	},
	plugins: [],
};
