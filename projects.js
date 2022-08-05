const fs = require("fs");
const path = require("path");

const root = path.resolve(".");
const target = "assets/images";
const dir_path = path.join(root, "assets/images/desain");
// const projects = fs.readFileSync(path.join(root, "data/projects.json"));
const list = fs.readdirSync(dir_path);
const result = [];
let count = 0;
for (const item of list) {
  const sub_list = fs.readdirSync(path.join(dir_path, item));
  for (const sub_item of sub_list) {
    result.push({
      id: count++,
      auth: item,
      cat: "",
      src: path.join(target, item, sub_item),
    });
  }
}
fs.writeFileSync(
  path.join(root, "assets/data/projects.v2.json"),
  JSON.stringify(result, null, "\t")
);
// const projects = fs.readFileSync(path.join(root, "data/projects.json"));
