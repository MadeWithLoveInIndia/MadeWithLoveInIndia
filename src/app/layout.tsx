import clsx from 'clsx'
import { type Metadata } from 'next'
import { DM_Sans } from 'next/font/google'

import '@/styles/tailwind.css'

const dmSans = DM_Sans({
  subsets: ['latin'],
  weight: ['400', '500', '700'],
  display: 'swap',
  variable: '--font-dm-sans',
})

export const metadata: Metadata = {
  metadataBase: new URL('https://madewithloveinindia.org'),
  title: {
    template: '%s - Made with Love in India',
    default:
      'Made with Love in India - A movement to celebrate, promote, and build a brand, India.',
  },
  description:
    'At the crossroads of tradition and innovation, where creativity flourishes and entrepreneurship thrives, lies a remarkable movement founded in April 2013 — Made with Love in India. Rooted in the heart of this diverse nation, our mission is to spotlight the incredible stories, talents, and endeavors that define the spirit of India’s entrepreneurial landscape.',
  manifest: '/site.webmanifest',
  themeColor: '#f43f5e',
  icons: [
    { rel: 'icon', sizes: '32x32', url: '/favicon-32x32.png' },
    { rel: 'icon', sizes: '16x16', url: '/favicon-16x16.png' },
    { rel: 'apple-touch-icon', url: '/apple-touch-icon.png' },
    { rel: 'mask-icon', color: '#f43f5e', url: '/safari-pinned-tab.svg' },
  ],
  openGraph: {
    images: `https://v1.screenshot.11ty.dev/${encodeURIComponent(
      'https://madewithloveinindia.org',
    )}/opengraph`,
  },
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html
      lang="en"
      className={clsx(
        'h-full scroll-smooth bg-white antialiased',
        dmSans.variable,
      )}
    >
      <body className="flex min-h-full">
        <div className="flex w-full flex-col">{children}</div>
      </body>
    </html>
  )
}
