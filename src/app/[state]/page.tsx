import { slugify } from '@/app/[state]/[city]/(entries)/component'
import { BackgroundImage } from '@/components/BackgroundImage'
import { Container } from '@/components/Container'
import { Layout } from '@/components/Layout'
import { Schedule } from '@/components/Schedule'
import data from '@/generated/data.json'
import { IconArrowLeft } from '@tabler/icons-react'
import type { GetStaticPaths } from 'next'
import Link from 'next/link'

export const states = [
  { slug: 'andaman-and-nicobar-islands' },
  { slug: 'andhra-pradesh' },
  { slug: 'arunachal-pradesh' },
  { slug: 'assam' },
  { slug: 'bihar' },
  { slug: 'chandigarh' },
  { slug: 'chhattisgarh' },
  { slug: 'dadra-and-nagar-haveli-and-daman-and-diu' },
  { slug: 'delhi' },
  { slug: 'goa' },
  { slug: 'gujarat' },
  { slug: 'haryana' },
  { slug: 'himachal-pradesh' },
  { slug: 'jammu-and-kashmir' },
  { slug: 'jharkhand' },
  { slug: 'karnataka' },
  { slug: 'kerala' },
  { slug: 'ladakh' },
  { slug: 'lakshadweep' },
  { slug: 'madhya-pradesh' },
  { slug: 'maharashtra' },
  { slug: 'manipur' },
  { slug: 'meghalaya' },
  { slug: 'mizoram' },
  { slug: 'nagaland' },
  { slug: 'odisha' },
  { slug: 'puducherry' },
  { slug: 'punjab' },
  { slug: 'rajasthan' },
  { slug: 'sikkim' },
  { slug: 'tamil-nadu' },
  { slug: 'telangana' },
  { slug: 'tripura' },
  { slug: 'uttar-pradesh' },
  { slug: 'uttarakhand' },
  { slug: 'west-bengal' },
]

/**
 * Convert a slug into a human readable state name
 * @param slug - Slug of the state
 * @returns Human readable state name
 * @example getStateName('andaman-and-nicobar-islands') // Andaman and Nicobar Islands
 */
export const getStateName = (slug: string) =>
  slug
    .split('-')
    .map((word) => word[0].toUpperCase() + word.slice(1))
    .join(' ')
    .replace(/ And /g, ' & ')
    .replace('Haveli & Daman', 'Haveli and Daman') // Fix for Dadra and Nagar Haveli and Daman and Diu

export const getStaticPaths: GetStaticPaths = async () => {
  return {
    paths: states.map(({ slug: state }) => ({ params: { state } })),
    fallback: false,
  }
}

export function ListItem({ item }: { item: any }) {
  return (
    <div className="relative flex transition-opacity hover:opacity-70">
      <div className="mr-5 flex h-16 w-16 shrink-0 items-center justify-center rounded-xl shadow">
        <img
          alt=""
          src={
            'github' in item && item.github
              ? `https://github.com/${item.github}.png?size=200`
              : 'url' in item && typeof item.url === 'string'
              ? `https://logo.clearbit.com/${new URL(item.url).hostname}`
              : ''
          }
          className="rounded-xl"
        />
      </div>
      <div className="col-span-3 grow space-y-1">
        {'name' in item && typeof item.name === 'string' && (
          <div className="font-semibold">
            <Link
              className="parent-relative-full-link"
              href={`/${slugify(item.state)}/${slugify(item.city)}/${
                item.slug
              }`}
            >
              {item.name}
            </Link>
          </div>
        )}
        {'tagline' in item && typeof item.tagline === 'string' && (
          <p className="text-sm leading-snug text-slate-500">{item.tagline}</p>
        )}
      </div>
    </div>
  )
}

export default function StatePage({ params }: { params: { state: string } }) {
  const stateName = getStateName(params.state)
  const items = data.filter(({ state }) => slugify(state) === params.state)

  return (
    <Layout>
      <div className="relative pt-20 sm:pt-36">
        <BackgroundImage position="right" className="-bottom-14 -top-36" />
        <Container className="relative grid gap-8 md:grid-cols-2">
          <div>
            <Link
              href="/#states"
              className="mb-4 inline-flex items-center space-x-2 font-medium text-rose-900 hover:text-rose-700"
            >
              <IconArrowLeft className="h-5 w-5" strokeWidth={1.5} />
              <span>More states</span>
            </Link>
            <h1 className="font-display text-5xl font-bold tracking-tighter sm:text-7xl">
              {stateName}
            </h1>
            {items.length === 0 && (
              <p className="mt-4 text-lg text-slate-500">
                No initiatives have been listed for {stateName} yet.
              </p>
            )}
          </div>
          <div>
            <img
              alt={`Monuments in ${stateName}`}
              src={`https://tse2.mm.bing.net/th?q=${encodeURIComponent(
                `${stateName}, India monument`,
              )}&w=700&h=400&c=7&rs=1&p=0&dpr=3&pid=1.7&mkt=en-IN&adlt=moderate`}
              className="aspect-video w-full rounded-2xl border object-cover shadow-lg"
            />
          </div>
        </Container>
      </div>
      <Container>
        <div className="my-20 grid gap-16 md:grid-cols-4">
          {items.map((item, index) => (
            <ListItem key={`${item.slug}_${index}`} item={item} />
          ))}
        </div>
      </Container>
      <Schedule />
    </Layout>
  )
}
