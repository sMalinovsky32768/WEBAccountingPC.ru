USE [E:\ДИПЛОМ\ACCOUNTINGPC\ACCOUNTINGPC\ACCOUNTINGPC\ACCOUNTINGDB.MDF]
GO
/****** Object:  Table [dbo].[administration]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[administration](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[nameDepartment] [nvarchar](30) NOT NULL,
	[nameEmployee] [nvarchar](50) NOT NULL,
	[location] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[audience]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[audience](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[name] [nvarchar](4) NOT NULL,
	[mapFile] [nvarchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[changeLog]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[changeLog](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[type_device] [nvarchar](30) NOT NULL,
	[type_change] [nvarchar](50) NOT NULL,
	[id_device] [int] NOT NULL,
	[from] [int] NULL,
	[to] [int] NULL,
	[description] [nvarchar](100) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[installedSoftware]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[installedSoftware](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[computer] [int] NOT NULL,
	[license] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[interactiveWhiteboard]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[interactiveWhiteboard](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[code] [nvarchar](15) NOT NULL,
	[name] [nvarchar](20) NOT NULL,
	[doc] [nvarchar](50) NOT NULL,
	[location] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[license]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[license](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[software_name] [nvarchar](30) NOT NULL,
	[count] [int] NOT NULL,
	[doc] [nvarchar](50) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[location]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[location](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[audience] [int] NOT NULL,
	[place] [int] NOT NULL,
	[description] [nvarchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[monitor]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[monitor](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[code] [nvarchar](15) NOT NULL,
	[name] [nvarchar](20) NOT NULL,
	[doc] [nvarchar](50) NOT NULL,
	[screenDiagonalInch] [nvarchar](7) NULL,
	[screenResolution] [nvarchar](10) NULL,
	[location] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[networkSwitch]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[networkSwitch](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[code] [nvarchar](15) NOT NULL,
	[name] [nvarchar](20) NOT NULL,
	[numberOfPorts] [int] NULL,
	[doc] [nvarchar](50) NOT NULL,
	[audience] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PC]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PC](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[type] [nvarchar](20) NOT NULL,
	[code] [nvarchar](15) NOT NULL,
	[name] [nvarchar](20) NOT NULL,
	[CPU] [nvarchar](20) NOT NULL,
	[RAM] [int] NOT NULL,
	[videoAdapter] [nvarchar](20) NULL,
	[screenDiagonalInch] [nvarchar](7) NULL,
	[screenResolution] [nvarchar](10) NULL,
	[doc] [nvarchar](50) NOT NULL,
	[location] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[printScan]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[printScan](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[type] [nvarchar](20) NOT NULL,
	[code] [nvarchar](15) NOT NULL,
	[name] [nvarchar](20) NOT NULL,
	[max_format] [nvarchar](3) NULL,
	[doc] [nvarchar](50) NOT NULL,
	[location] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[projector]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[projector](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[code] [nvarchar](15) NOT NULL,
	[name] [nvarchar](20) NOT NULL,
	[doc] [nvarchar](50) NOT NULL,
	[audience] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[teacher]    Script Date: 14.12.2019 19:01:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[teacher](
	[id] [int] IDENTITY(0,1) NOT NULL,
	[location] [int] NOT NULL,
	[name] [nvarchar](50) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
