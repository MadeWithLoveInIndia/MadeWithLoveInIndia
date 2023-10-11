'use client'

import { slugify } from '@/data'
import Link from 'next/link'

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
