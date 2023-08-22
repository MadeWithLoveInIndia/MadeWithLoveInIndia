import { Layout } from '@/components/Layout'

export default function MainLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return <Layout>test - {children}</Layout>
}
