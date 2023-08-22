import { slugify } from '@/app/[state]/[city]/(entries)/component'
import { states } from '@/app/[state]/page'
import data from '@/generated/data.json'
import { MetadataRoute } from 'next'

export default function sitemap(): MetadataRoute.Sitemap {
  return [
    ...states.map((state) => ({
      url: `https://madewithloveinindia.org/${state.slug}`,
      lastModified: new Date(),
    })),
    ...data
      .map(({ city, state }) => ({
        params: { state, city: slugify(city) },
      }))
      .filter(
        (value, index, self) =>
          self.findIndex((v) => v.params.city === value.params.city) === index,
      )
      .map(({ params: { state, city } }) => ({
        url: `https://madewithloveinindia.org/${state}/${city}`,
        lastModified: new Date(),
      })),
    ...data.map(({ city, state, slug }) => ({
      url: `https://madewithloveinindia.org/${state}/${slugify(city)}/${slug}`,
      lastModified: new Date(),
    })),
  ]
}
