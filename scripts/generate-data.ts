const fs = require('fs/promises')
const matter = require('gray-matter')

;(async () => {
  const files = await fs.readdir('./data')
  const result: unknown[] = []
  for (const file of files) {
    const text = await fs.readFile(`./data/${file}`, 'utf-8')
    const data = matter(text)
    result.push({
      ...data.data,
      slug: file.replace('.mdx', ''),
    })
  }
  await fs.writeFile(
    './src/generated/data.json',
    JSON.stringify(result, null, 2),
  )
})()
