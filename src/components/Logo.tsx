import Link from 'next/link'

export function Logo() {
  return (
    <Link href="/" className="text-2xl font-semibold">
      Made with <span className="love">Love</span> in India
    </Link>
  )
}
