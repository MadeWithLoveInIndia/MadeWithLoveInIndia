import { BackgroundImage } from '@/components/BackgroundImage'
import { Container } from '@/components/Container'
import { Layout } from '@/components/Layout'
import { ListItem } from '@/components/ListItem'
import { Schedule } from '@/components/Schedule'
import { getStateName, slugify, states } from '@/data'
import data from '@/generated/data.json'
import { IconArrowLeft } from '@tabler/icons-react'
import type { Metadata } from 'next'
import Link from 'next/link'
import { redirect } from 'next/navigation'

type Props = {
  params: { state: string; city: string }
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  return {
    openGraph: {
      images: `https://v1.screenshot.11ty.dev/${encodeURIComponent(
        `https://madewithloveinindia.org/${params.state}/${params.city}`,
      )}/opengraph`,
    },
  }
}

export const generateStaticParams = async () => {
  return data
    .map(({ city, state }) => ({ state, city: slugify(city) }))
    .filter(
      (value, index, self) =>
        self.findIndex((v) => v.city === value.city) === index,
    )
}

export default function CityPage({ params }: Props) {
  const cityName = getStateName(params.city)
  const stateName = getStateName(params.state)
  const items = data.filter(
    ({ state, city }) =>
      slugify(state) === params.state && slugify(city) === params.city,
  )
  const state = states.find(({ slug }) => slug === params.state)
  if (!state) return redirect('/')

  return (
    <Layout>
      <div className="relative pt-20 sm:pt-36">
        <BackgroundImage position="right" className="-bottom-14 -top-36" />
        <Container className="relative grid gap-8 md:grid-cols-2">
          <div>
            <Link
              href={`/${params.state}`}
              className="mb-4 inline-flex items-center space-x-2 font-medium text-rose-900 hover:text-rose-700"
            >
              <IconArrowLeft className="h-5 w-5" strokeWidth={1.5} />
              <span>{stateName}</span>
            </Link>
            <h1 className="font-display text-5xl font-bold tracking-tighter sm:text-7xl">
              {cityName}
            </h1>
            {items.length === 0 && (
              <p className="mt-4 text-lg text-slate-500">
                No initiatives have been listed for {cityName} yet.
              </p>
            )}
          </div>
          <div>
            <img
              alt={`Monuments in ${stateName}`}
              src={`https://tse2.mm.bing.net/th?q=${encodeURIComponent(
                `${cityName}, ${stateName}, India monument`,
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
