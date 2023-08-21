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
  title: {
    template: '%s - Made with Love in India',
    default:
      'Made with Love in India - A movement to celebrate, promote, and build a brand, India.',
  },
  description:
    'At the crossroads of tradition and innovation, where creativity flourishes and entrepreneurship thrives, lies a remarkable movement founded in April 2013 — Made with Love in India. Rooted in the heart of this diverse nation, our mission is to spotlight the incredible stories, talents, and endeavors that define the spirit of India’s entrepreneurial landscape.',
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html
      lang="en"
      className={clsx('h-full bg-white antialiased', dmSans.variable)}
    >
      <body className="flex min-h-full">
        <div className="flex w-full flex-col">{children}</div>
      </body>
    </html>
  )
}
