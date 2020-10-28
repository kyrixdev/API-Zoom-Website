module.exports = {
  future: {
    // removeDeprecatedGapUtilities: true,
    // purgeLayersByDefault: true,
  },
  purge: [],
  theme: {
    extend: {},
  },
  variants: {},
  plugins: [],
}
module.exports = {
  plugins: [
    require('@tailwindcss/ui'),
  ]
}

module.exports = {
  plugins: [
    require('@tailwindcss/ui')({
      layout: 'sidebar',
    })
  ]
}