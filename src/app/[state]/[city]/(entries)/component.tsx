import { getStateName } from '@/app/[state]/page'
import { BackgroundImage } from '@/components/BackgroundImage'
import { Button } from '@/components/Button'
import { Container } from '@/components/Container'
import { Layout } from '@/components/Layout'
import { Newsletter } from '@/components/Newsletter'
import { Schedule } from '@/components/Schedule'
import { Sponsors } from '@/components/Sponsors'
import {
  IconArrowLeft,
  IconArrowRight,
  IconBrandFacebook,
  IconBrandGithub,
  IconBrandInstagram,
  IconBrandLinkedin,
  IconBrandTwitter,
  IconMap,
  IconMapPin,
  IconNews,
  IconWorldWww,
} from '@tabler/icons-react'
import Link from 'next/link'

export const slugify = (str: string) =>
  str
    .toLowerCase()
    .replace(/ /g, '-')
    .replace(/[^\w-]+/g, '')

export function CollectionPage({
  data,
}: {
  data: {
    slug: string
    type: string
    name: string
    url: string
    tagline: string
    city: string
    state: string
    blog?: string
    github_username?: string
    github_repository_name?: string
    facebook?: string
    twitter?: string
    instagram?: string
    linkedin_profile?: string
    linkedin_page?: string
  }
}) {
  const url = new URL(data.url)
  url.searchParams.set('utm_source', 'madewithloveinindia')
  url.searchParams.set('utm_medium', 'link')
  url.searchParams.set('utm_campaign', data.slug)

  return (
    <Layout>
      <div className="relative pt-20 sm:pt-36">
        <BackgroundImage position="right" className="-bottom-14 -top-36" />
        <Container className="relative grid gap-8 md:grid-cols-2">
          <div>
            <Link
              href="/"
              className="mb-4 inline-flex items-center space-x-2 font-medium text-rose-900 hover:text-rose-700"
            >
              <IconArrowLeft className="h-5 w-5" strokeWidth={1.5} />
              <span>More initiatives</span>
            </Link>
            <h1 className="font-display text-5xl font-bold tracking-tighter sm:text-7xl">
              {data.name}
            </h1>
            <div className="mt-6 space-y-6 font-display text-2xl tracking-tight text-rose-900">
              {data.tagline}
            </div>
            <ul className="mt-6 space-y-2">
              <li>
                <Link
                  href={`/${data.state}/${slugify(data.city)}`}
                  className="inline-flex items-center space-x-3 opacity-80 transition-opacity hover:opacity-100"
                >
                  <IconMapPin className="h-5 w-5" strokeWidth={1.5} />
                  <span>City</span>
                  <span className="font-semibold">{data.city}</span>
                </Link>
              </li>
              <li>
                <Link
                  href={`/${data.state}`}
                  className="inline-flex items-center space-x-3 opacity-80 transition-opacity hover:opacity-100"
                >
                  <IconMap className="h-5 w-5" strokeWidth={1.5} />
                  <span>State</span>
                  <span className="font-semibold">
                    {getStateName(data.state)}
                  </span>
                </Link>
              </li>
              {[
                {
                  key: 'blog',
                  label: 'Blog',
                  Icon: IconNews,
                  format: (value: string) => value,
                },
                {
                  key: 'url',
                  label: 'Website',
                  Icon: IconWorldWww,
                  format: (value: string) => value,
                },
                {
                  key: 'github_repository_name',
                  label: 'GitHub',
                  Icon: IconBrandGithub,
                  format: (value: string, originalData: typeof data) =>
                    `https://github.com/${originalData.github_username}/${value}`,
                },
                {
                  key: 'facebook',
                  label: 'Facebook',
                  Icon: IconBrandFacebook,
                  format: (value: string) =>
                    `https://www.facebook.com/${value}`,
                },
                {
                  key: 'twitter',
                  label: 'Twitter',
                  Icon: IconBrandTwitter,
                  format: (value: string) => `https://twitter.com/${value}`,
                },
                {
                  key: 'instagram',
                  label: 'Instagram',
                  Icon: IconBrandInstagram,
                  format: (value: string) =>
                    `https://www.instagram.com/${value}/`,
                },
                {
                  key: 'linkedin_profile',
                  label: 'LinkedIn',
                  Icon: IconBrandLinkedin,
                  format: (value: string) =>
                    `https://www.linkedin.com/in/${value}/`,
                },
                {
                  key: 'linkedin_page',
                  label: 'LinkedIn',
                  Icon: IconBrandLinkedin,
                  format: (value: string) =>
                    `https://www.linkedin.com/company/${value}/`,
                },
              ].map((item) => {
                const value = data[item.key as keyof typeof data]
                if (!value) return null

                return (
                  <li key={item.key}>
                    <a
                      href={item.format(value, data)}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="inline-flex items-center space-x-3 opacity-80 transition-opacity hover:opacity-100"
                    >
                      <item.Icon className="h-5 w-5" strokeWidth={1.5} />
                      <span>{item.label}</span>
                      <span className="font-semibold">
                        {value.startsWith('http')
                          ? new URL(value).hostname
                          : value}
                      </span>
                    </a>
                  </li>
                )
              })}
            </ul>
            <Button
              href={url.toString()}
              target="_blank"
              rel="noopener noreferrer"
              className="mt-10 inline-flex w-full items-center justify-between space-x-2 sm:w-auto"
            >
              <span>{`Go to ${data.name}`}</span>
              <IconArrowRight className="h-5 w-5" strokeWidth={1.5} />
            </Button>
            <Button href="/#join" className="mt-4 w-full sm:hidden">
              Join the movement
            </Button>
          </div>
          <div>
            <img
              alt={`Screenshot of ${data.name}`}
              src={`https://v1.screenshot.11ty.dev/${encodeURIComponent(
                data.url,
              )}/opengraph`}
              className="w-full rounded-2xl border shadow-lg"
            />
          </div>
        </Container>
      </div>
      <Schedule />
      <Newsletter />
      <Sponsors />
    </Layout>
  )
}
