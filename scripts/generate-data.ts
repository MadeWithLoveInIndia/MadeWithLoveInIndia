const fs = require('fs/promises')
const validate = require('jsonschema').validate

;(async () => {
  const files = await fs.readdir('./data')
  const schema = JSON.parse(await fs.readFile('./public/schema.json', 'utf-8'))
  const result: unknown[] = []
  for (const file of files) {
    const text = await fs.readFile(`./data/${file}`, 'utf-8')
    const data = JSON.parse(text)
    const validated = validate(data, schema)
    if (validated.errors.length > 0)
      throw new Error(`Invalid data: ${file} - ${validated.errors[0]}`)
    result.push({
      ...data,
      slug: file.replace('.json', ''),
    })

    await fs.mkdir(
      `./src/app/[state]/[city]/(entries)/(data)/${file.replace('.json', '')}`,
      { recursive: true },
    )
    await fs.writeFile(
      `./src/app/[state]/[city]/(entries)/(data)/${file.replace(
        '.json',
        '',
      )}/page.tsx`,
      `import { type Metadata } from 'next';
import { CollectionPage } from "@/app/[state]/[city]/(entries)/component";

export async function generateMetadata({
  params,
}: {
  params: { state: string; city: string };
}): Promise<Metadata> {
  return {
    title: "${data.name}",
    description: "${data.name} (${
      data.tagline
    }) is part of Made with Love in India, a movement to celebrate, promote, and build a brand, India.",
    openGraph: {
      images: \`https://v1.screenshot.11ty.dev/\${encodeURIComponent(
        \`https://madewithloveinindia.org/\${params.state}/\${params.city}/${file.replace(
          '.json',
          '',
        )}\`,
      )}/opengraph\`,
    },
  };
}

const data = JSON.parse(\`${JSON.stringify(data)}\`);

export default function Page() {
  return <CollectionPage data={data} />
}
`,
    )
  }
  await fs.mkdir('./src/generated', { recursive: true })
  await fs.writeFile(
    './src/generated/data.json',
    JSON.stringify(
      (result as { slug: string; name: string; type: string }[]).sort(
        (a, b) => {
          const FEATURED = [
            'hike-messenger',
            'snapdeal',
            'oswald-labs',
            'protecta',
          ]
          if (FEATURED.includes(a.slug) && !FEATURED.includes(b.slug)) return -1
          if (!FEATURED.includes(a.slug) && FEATURED.includes(b.slug))
            return a.slug < b.slug ? -1 : 1

          if (a.type === b.type) {
            if (a.name === b.name) return 0
            return a.name < b.name ? -1 : 1
          }
          const order = [
            'company',
            'nonprofit',
            'institution',
            'community',
            'personal website',
            'app',
            'open source project',
            'other',
          ]

          const aIndex = order.indexOf(a.type)
          const bIndex = order.indexOf(b.type)
          if (aIndex < bIndex) return -1
          if (aIndex > bIndex) return 1
          return 0
        },
      ),
      null,
      2,
    ),
  )
})()
