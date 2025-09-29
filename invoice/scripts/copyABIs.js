const fs = require('fs');
const path = require('path');

// Folder paths
const artifactsDir = path.join(__dirname, '../artifacts/contracts');
const abiOutputDir = path.join(__dirname, '../contracts-abi');

// Creates the destination folder if it does not exist
if (!fs.existsSync(abiOutputDir)) {
    fs.mkdirSync(abiOutputDir, { recursive: true });
}

// Browses ABI files and copies them
function copyABIs() {
    fs.readdirSync(artifactsDir).forEach((file) => {
        const fullPath = path.join(artifactsDir, file, `${file.replace('.sol', '')}.json`);
        if (fs.existsSync(fullPath)) {
            const abiData = JSON.parse(fs.readFileSync(fullPath, 'utf8')).abi;
            fs.writeFileSync(path.join(abiOutputDir, `${file.replace('.sol', '')}.abi.json`), JSON.stringify(abiData, null, 2));
        }
    });
    console.log(`ABI copied to ${abiOutputDir}`);
}

copyABIs();
