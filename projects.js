const fs = require("fs");
const path = require("path");

const root = path.resolve(".");
const target = "assets/images/desain";
const dir_path = path.join(root, target);
// const projects = fs.readFileSync(path.join(root, "data/projects.json"));
const authors = fs.readdirSync(dir_path);
const result = [];
let count = 0;
for (const author of authors) {
  const categories = fs.readdirSync(path.join(dir_path, author));
  for (const category of categories) {
    const images = fs.readdirSync(path.join(dir_path, author, category));
    for (const image of images) {
      result.push({
        id: count++,
        auth: author,
        cat: category,
        src: path.join(target, author, category, image),
      });
    }
  }
}
fs.writeFileSync(
  path.join(root, "assets/data/projects.v2.json"),
  JSON.stringify(result, null, "\t")
);
// const projects = fs.readFileSync(path.join(root, "data/projects.json"));
