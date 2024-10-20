const path = require("path");

module.exports = {
  entry:
    "./packages/rr_sondermetalle/ContentBlocks/ContentElements/dashboard-react/Assets/src/main.js",
  output: {
    filename: "Frontend.js",
    path: path.resolve(
      __dirname,
      "./packages/rr_sondermetalle/ContentBlocks/ContentElements/dashboard-react/Assets"
    ),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env", "@babel/preset-react"],
          },
        },
      },
    ],
  },
  mode: "development",
};
